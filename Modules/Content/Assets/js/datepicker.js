     
    function dateRangePickerFunctions(){
        var a;
        var b;
        var optionSet1 = {
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2012',
            maxDate: moment(),
            dateLimit: { days: 300},
            showDropdowns: true,
            showWeekNumbers: true,
            autoApply: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
            },
            opens: 'right',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        };

        var optionSet2 = {
          singleDatePicker:true
        }

        var cb = function(start, end, label) {
            $('#returnrange span').html(start.format('MMMM D, YYYY'));
            a=start.format('YYYY-MM-DD');
            b=end.format('YYYY-MM-DD');
            $('#expiry_date').val(b);
        };

        cb(moment(), moment(), "Last Month");
        $('#returnrange').daterangepicker(optionSet2,cb);
        $('#returnrange').val(daterangepicker);
        $('#expiry_date').val(b);
            var results='';
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        }


      