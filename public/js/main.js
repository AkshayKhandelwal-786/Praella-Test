$(document).ready(function() {
    $(".toggle-password").click(function(){
    var id = $(this).attr('data-id');
        const password = document.querySelector('#'+id);
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
});
$(function () {
    $("#start_date").datepicker({
        format: 'dd-mm-yyyy',
        startDate: new Date(),
        todayHighlight: true,
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#end_date').datepicker('setStartDate', minDate);
    });
    $("#end_date").datepicker({
        format: 'dd-mm-yyyy',
        startDate: new Date(),
        autoclose: true,
    }).on('changeDate', function (selected) {
        var maxDate = new Date(selected.date.valueOf());
        $('#start_date').datepicker('setEndDate', maxDate);
    });
});