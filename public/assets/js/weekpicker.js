var WeekPicker = (function ($) {
    return function () {
        var $week_label = '__weekpicker_label';
        var $week_left = '__weekpicker_left';
        var $week_right = '__weekpicker_right';
        var $container;
        var $currentWeekNumber;
        var $currentYear;
        var $currentDate = new Date();
        var $value = {};
        var $control_html = "<ul class='weekpicker'><li class='" + $week_left + "'><a href='#'>&lt;</a></li><li class='" + $week_label + "'>Week picker</li><li class='" + $week_right + "'><a href='#'>&gt;</a></li></ul>";
        var $onChange;


        Date.prototype.getMonthAbbr = function(){
            var month_abbrs = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            return month_abbrs[this.getMonth()];
        }

        function init(container, onchange) {
            $container = container;
            $onChange = onchange;
            $($control_html).appendTo($container);            
            updateWeek($currentDate);

            $container.find("li." + $week_left).on("onchange", function (event, value) {
                $onChange(value);
            });
            $container.find("li." + $week_right).on("onchange", function (event, value) {
                $onChange(value);
            });

            $container.on("click", "ul li." + $week_left, function (event) {
                $currentDate = addDays($currentDate, -7);
                updateWeek($currentDate);
                $(this).trigger("onchange", [$value]);
            });
            $container.on("click", "ul li." + $week_right, function (event) {
                $currentDate = addDays($currentDate, 7);
                updateWeek($currentDate);
                $(this).trigger("onchange", [$value]);

            });
        };

        function addDays(date, days) {
            var result = new Date(date);
            result.setDate(result.getDate() + days);
            return result;
        }

        function updateWeek(date) {
            $value = {year: date.getFullYear(), weekno: ISO8601_week_no(date)};
            $container.find("." + $week_label).html( formatWeekLabel($value));
        }

        function formatWeekLabel(data){
            var date = getSundayFromWeekNum(data.weekno, data.year);
            var date2 = addDays(date, 6);
            return date.getMonthAbbr() + " " + date.getDate() + ", " + date.getFullYear()
            + " - " +  date2.getMonthAbbr() + " " + date2.getDate() + ", " + date2.getFullYear()
        }

        function formattedDateOfWeek(date, index) {
            var date = getDateOfWeek(date, index);
            return "Week of " + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + " ";
        }


        function getDateOfWeek(date, index) {
            var momentdate = moment(date, "yyyy-MM-ddTHH:mm:ss");
            var $currentWeekNumber = momentdate.week();
            var $currentYear = momentdate.year();

            //get monday of week
            var day = date.getDay() || 7;
            if (day !== 1)
                date.setHours(-24 * (day - 1));

            date.setDate(date.getDate() + index);

            return date;
        }

        function getSelectedValue() {
            return $value;
        };

        function getSundayFromWeekNum(weekNum, year) {
            var sunday = new Date(year, 0, (1 + (weekNum - 1) * 7));
            while (sunday.getDay() !== 0) {
                sunday.setDate(sunday.getDate() - 1);
            }
            return sunday;
        }
        
        function ISO8601_week_no(dt) 
        {
            var tdt = new Date(dt.valueOf());
            var dayn = (dt.getDay() + 6) % 7;
            tdt.setDate(tdt.getDate() - dayn + 3);
            var firstThursday = tdt.valueOf();
            tdt.setMonth(0, 1);
            if (tdt.getDay() !== 4) 
            {
            tdt.setMonth(0, 1 + ((4 - tdt.getDay()) + 7) % 7);
            }
            return 1 + Math.ceil((firstThursday - tdt) / 604800000);
        };

        return {
            init: init,
            getSelectedValue: getSelectedValue
        }
    }
})(jQuery);