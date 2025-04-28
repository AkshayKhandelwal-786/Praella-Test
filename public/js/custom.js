$('#role').change(function() {
    var role = this.value;
    if (role == 2) {
        $('.organisation').show();
        $('#organization').prop('disabled', false);

        $('.sub_organisation').hide();
        $('#sub_organization').prop('disabled', true);

        
    } else if (role == 3) {
        $('.organisation').hide();
        $('#organization').prop('disabled', true);

        $('.sub_organisation').show();
        $('#sub_organization').prop('disabled', false);
    }else {
        $('.organisation').hide();
        $('#organization').prop('disabled', true);

        $('.sub_organisation').hide();
        $('#sub_organization').prop('disabled', true);
    }
});