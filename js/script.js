$(function() {
    $('input[name="daterange"]').daterangepicker({
        maxSpan: {
            "days": 60
        },
        startDate: moment().subtract(30, 'days'), // 30 days before today
        endDate: moment(),
        maxDate: moment(), // Sets maxDate to today's date
        opens: 'left'
    }, function(start, end, label) {
        $.ajax({
            type: 'get',
            url: 'index.php',
            data:{
                daterange: $('input[name="daterange"]').val(),
            },
            success:function(res) {
                console.log($(res).find('.table-div').html())
                $('.table-div').html($(res).find('.table-div').html());

            }
        });
    });
});