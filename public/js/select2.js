$(id).select2({
    placeholder: placeholder
});
$('#role').change(function() {
    var role = this.value;
    if (role == userRole) {
        $('.project').show();
        $('#project').prop('disabled', false);
    } else {
        $('.project').hide();
        $('#project').prop('disabled', true);
    }
});