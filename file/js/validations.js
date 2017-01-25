
      function SubmitFrm(){
      
         var SearchFrom = document.getElementById("autocomplete").value;
         var Searchto = document.getElementById("autocompleteto").value;
         var SearchDate = document.getElementById("dateFrom").value;
         var SearchDateto = document.getElementById("dateTO").value;
         var Searchtime = document.getElementById("timeNow").value;
         var SearchType = $("input[name=checkbox-01]:checked").val();
         //var SearchCar = $("input[name=checkbox-02]:checked").val()
         //var SearchAc = document.getElementByName('checkbox-03[]').val();
         var todayDate = new Date();
        var fromdate = todayDate.getDate();
        var frommonth = todayDate.getMonth() + 1;
        var hour = todayDate.getHours(); // => 9
        var min = todayDate.getMinutes();
            if(hour<10){
                hour='0'+hour
            } 
            if(min<10){
                min='0'+min
            } 
         
         //var EnteredDate = $("#dateFrom").val();
        var fdate = SearchDate.substring(3, 5);
        var fmonth = SearchDate.substring(0, 2);
        var fyear = SearchDate.substring(6, 10);

        var inputDate = new Date(fyear, fmonth - 1, fdate);

        var actualtoday = new Date();
        
        var cdd = actualtoday.getDate();
        var cmm = actualtoday.getMonth()+1; //January is 0!

        var cyyyy = actualtoday.getFullYear();
        if(cdd<10){
            cdd='0'+cdd
        } 
        if(cmm<10){
            cmm='0'+cmm
        } 
        //var today = mm+'/'+dd+'/'+yyyy;
         //var todaydate = new Date(cyyyy, cmm - 1, cdd);
         //alert(Searchtime+hour);
        if (cmm == fmonth && cdd == fdate) {
          var timesplitone = Searchtime.substring(0, 2);
          var timesplittwo = Searchtime.substring(3, 5);
          if(timesplitone < hour){
             $('#myModalCompleteDetailsthree').modal('show');
             $('#message').text ('please enter time greater than present time');
            //alert('please enter time greater than present time');
            return false;
          }else if(timesplitone == hour){
            if(min >= timesplittwo){
                $('#myModalCompleteDetailsthree').modal('show');
                 $('#message').text ('please enter time greater than present time');
                     //alert('please enter time greater than present time');
                     return false;
            }
          }
        }

         var checkboxes = document.getElementsByName('checkbox-02');
            var Carvals = [];
            for (var i=0, n=checkboxes.length;i<n;i++) {
              if (checkboxes[i].checked) 
              {
               // Carvals += checkboxes[i].value+",";
                Carvals.push(checkboxes[i].value);
              }
            }
          var Accheckboxes = document.getElementsByName('checkbox-03');
            var Acvals = [];
            for (var i = 0, n=Accheckboxes.length; i<n;i++) {
              if (Accheckboxes[i].checked) 
              {
                //Acvals += Accheckboxes[i].value+",";
                Acvals.push(Accheckboxes[i].value);
              }
            }
            document.getElementById('selectedac').value = Acvals;
             
             document.getElementById('selectedcar').value =Carvals;
          //  alert(Acvals);
             
         if(!SearchFrom)
         {
            document.getElementById('autocomplete').placeholder = 'Please Enter Pickup Address';
            document.getElementById('autocomplete').style.border = '1px solid red';
            return false;
         }
         else if(!Searchto)
         {
            document.getElementById('autocomplete').style.border = '';
            document.getElementById('autocompleteto').placeholder = 'Please Enter Pickup Address';
            document.getElementById('autocompleteto').style.border = '1px solid red';
            return false;
         }else if(!SearchDate)
         {
             document.getElementById('autocompleteto').style.border = '';
             document.getElementById('autocomplete').style.border = '';
             document.getElementById('dateFrom').placeholder = 'Please Enter Date';
             document.getElementById('dateFrom').style.border = '1px solid red';
             return false;

         }else if(!SearchDateto && SearchType != 1)
         {
             document.getElementById('autocompleteto').style.border = '';
             document.getElementById('autocomplete').style.border = '';
             document.getElementById('dateFrom').style.border = '';
             document.getElementById('dateTO').placeholder = 'Please Enter Date';
             document.getElementById('dateTO').style.border = '1px solid red';
             return false;

         }
         else if(!Searchtime)
         {
             document.getElementById('autocompleteto').style.border = '';
             document.getElementById('autocomplete').style.border = '';
             document.getElementById('dateFrom').style.border = '';
             document.getElementById('dateTO').style.border = '';
             document.getElementById('timeNow').placeholder = 'Please Enter Time';
             document.getElementById('timeNow').style.border = '1px solid red';
             return false;
         }
         else if(!SearchType)
         {
             document.getElementById('autocompleteto').style.border = '';
             document.getElementById('autocomplete').style.border = '';
             document.getElementById('dateFrom').style.border = '';
             document.getElementById('dateTO').style.border = '';
             document.getElementById('timeNow').style.border = '';
             alert('Please select Round Type one way/two way');
             return false;
         }else if(checkDate('from') == false){
            alert('Please Enter Correct Return Date');
            return false;

         }else{
             document.getElementById('autocompleteto').style.border = '';
             document.getElementById('autocomplete').style.border = '';
             document.getElementById('dateFrom').style.border = '';
             document.getElementById('dateTO').style.border = '';
             document.getElementById('timeNow').style.border = '';

         }
      }
      
   function checkDate(param) {
       // var EnteredDate = document.getElementById("dateFrom").value; //for javascript
        if(param == 'to')
        var EnteredDate = $("#dateFrom").val();
        else 
        var EnteredDate = $("#dateTo").val(); // For JQuery

        var date = EnteredDate.substring(3, 5);
        var month = EnteredDate.substring(0, 2);
        var year = EnteredDate.substring(6, 10);
        //var cc = datepicker();
        var myDate = new Date(year, month - 1, date);

        var today = new Date();
        
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        //var today = mm+'/'+dd+'/'+yyyy;
         var todaydate = new Date(yyyy, mm - 1, dd);
        // alert(todaydate+myDate);
        if (myDate >= todaydate) {
           return true;
        }
        else {
            return false;
        }
    }

    $(function() {
        var dateToday = new Date();
        var dates = $("#dateTO, #dateFrom").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        minDate: dateToday,
        onSelect: function(selectedDate) {
            var option = this.id == "from" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
           // dates.not(this).datepicker("option", option, date);
        }
     });
        //$( ".datepicker" ).datepicker();
    });
   $(function() {
        $( ".timepicker" ).timepicker({
        timeFormat: 'H:i',
        minTime: '00:00:10', // 11:45:00 AM,
        maxHour: 20,
        maxMinutes: 30,
        startTime: new Date() ,// 3:00:00 PM - noon
        interval: 30 // 15 minutes
         });
      });
