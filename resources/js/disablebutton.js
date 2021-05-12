$(function(){
    $('#imageName').change(
        function(){
            if ($(this).val()) {
                $('#uploadButton').attr('disabled',false);
            }
        }
    );
});
