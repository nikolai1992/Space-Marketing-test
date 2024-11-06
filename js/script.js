$(function() {
    console.log(moment())
    console.log(moment().subtract(30, 'days'))
    $('input[name="daterange"]').daterangepicker({
        maxSpan: {
            "days": 60
        },
        maxDate: moment(), // Sets maxDate to today's date
        opens: 'left'
    }, function(start, end, label) {
        console.log($('input[name="daterange"]').val());
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