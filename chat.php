<?php
session_start();
//include('ChatFunction/connect.php');
include('checkLogin.php');
?>

<html lang="en"> 
    <?php require_once('Form/head_section.php') ?>
    <body>  
        <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        <div class="container">
            <br />
            <h3 align="center">USER STATUS</a></h3><br />
            <br />

            <div class="table-responsive">
                <h4 align="center">Online User</h4>
                <div id="user_details"></div>
                <div id="user_model_details"></div>

            </div>
        </div>
    </section>
</section>
</section>
<?php //require_once('Form/footer.php') ?>
</body>  
</html> 

<script>
    $(document).ready(function () {

        fetch_user();

        setInterval(function () {
            update_last_activity();
            fetch_user();
            update_chat_history_data();
        }, 5000);

        function fetch_user()
        {
            $.ajax({
                url: "ChatFunction/fetch_user.php",
                method: "POST",
                success: function (data) {
                    $('#user_details').html(data);
                }
            })
        }

        function update_last_activity()
        {
            $.ajax({
                url: "ChatFunction/update_last_activity.php",
                success: function ()
                {

                }
            })
        }

        function make_chat_dialog_box(to_user_id, to_user_name)
        {
            var modal_content = '<div id="user_dialog_' + to_user_id + '" class="user_dialog" title="You have chat with ' + to_user_name + '">';
            modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="' + to_user_id + '" id="chat_history_' + to_user_id + '">';
            modal_content += fetch_user_chat_history(to_user_id);
            modal_content += '</div>';
            modal_content += '<div class="form-group">';
            modal_content += '<textarea name="chat_message_' + to_user_id + '" id="chat_message_' + to_user_id + '" class="form-control chat_message"></textarea>';
            modal_content += '</div><div class="form-group" align="right">';
            modal_content += '<button type="button" name="send_chat" id="' + to_user_id + '" class="btn btn-info send_chat">Send</button></div></div>';
            $('#user_model_details').html(modal_content);
        }

        $(document).on('click', '.start_chat', function () {
            var to_user_id = $(this).data('touserid');
            var to_user_name = $(this).data('tousername');
            make_chat_dialog_box(to_user_id, to_user_name);
            $("#user_dialog_" + to_user_id).dialog({
                autoOpen: false,
                width: 400
            });
            $('#user_dialog_' + to_user_id).dialog('open');
        });

        $(document).on('click', '.send_chat', function () {
            var to_user_id = $(this).attr('id');
            var chat_message = $('#chat_message_' + to_user_id).val();
            $.ajax({
                url: "ChatFunction/insert_chat.php",
                method: "POST",
                data: {to_user_id: to_user_id, chat_message: chat_message},
                success: function (data)
                {
                    $('#chat_message_' + to_user_id).val('');
                    $('#chat_history_' + to_user_id).html(data);
                }
            })
        });

        function fetch_user_chat_history(to_user_id)
        {
            $.ajax({
                url: "ChatFunction/fetch_user_chat_history.php",
                method: "POST",
                data: {to_user_id: to_user_id},
                success: function (data) {
                    $('#chat_history_' + to_user_id).html(data);
                }
            })
        }

        function update_chat_history_data()
        {
            $('.chat_history').each(function () {
                var to_user_id = $(this).data('touserid');
                fetch_user_chat_history(to_user_id);
            });
        }

        $(document).on('click', '.ui-button-icon', function () {
            $('.user_dialog').dialog('destroy').remove();
        });

        $(document).on('focus', '.chat_message', function () {
            var is_type = 'yes';
            $.ajax({
                url: "ChatFunction/update_is_type_status.php",
                method: "POST",
                data: {is_type: is_type},
                success: function ()
                {

                }
            })
        });

        $(document).on('blur', '.chat_message', function () {
            var is_type = 'no';
            $.ajax({
                url: "ChatFunction/update_is_type_status.php",
                method: "POST",
                data: {is_type: is_type},
                success: function ()
                {

                }
            })
        });

    });

    $(document).on('click', '.remove_chat', function () {
        var chat_message_id = $(this).attr('id');
        if (confirm("Are you sure you want to remove this chat?"))
        {
            $.ajax({
                url: "ChatFunction/remove_chat.php",
                method: "POST",
                data: {chat_message_id: chat_message_id},
                success: function (data)
                {
                    update_chat_history_data();
                }
            })
        }
    });
</script>
<script class="include" type="text/javascript" src="Form/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="Form/lib/jquery.scrollTo.min.js"></script>
<script src="Form/lib/jquery.nicescroll.js" type="text/javascript"></script>
<script src="Form/lib/jquery.sparkline.js"></script>
<!--common script for all pages-->
<script src="Form/lib/common-scripts.js"></script>
<script type="text/javascript" src="Form/lib/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="Form/lib/gritter-conf.js"></script>
