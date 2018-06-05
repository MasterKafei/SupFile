$('#file_creation_file_file').change(function() {
    var fu1 = document.getElementById('file_creation_file_file');
    $('#file_creation_name').val(fu1.value.replace(/^.*[\\\/]/, ''));
});