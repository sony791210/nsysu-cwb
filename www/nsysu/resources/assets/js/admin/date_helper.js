/**
 * 格式化時間(yyyy-m-d)
 */
Date.prototype.yyyymmdd = function()
{
    var yyyy = this.getFullYear();
    var mm = this.getMonth() < 9 ? "0" + (this.getMonth() + 1) : (this.getMonth() + 1); // getMonth() is zero-based
    var dd  = this.getDate() < 10 ? "0" + this.getDate() : this.getDate();
    var pattern = /(\d{4})(\d{2})(\d{2})/;
    var dateString  = "".concat(yyyy).concat(mm).concat(dd);
    return dateString.replace(pattern, '$1-$2-$3');
};

/**
 * n年後(前)今天，n若未正整數則維n年後，反之則為n年前
 * @param int years
 */
Date.prototype.addYears = function(years)
{
    var strYear = this.getFullYear() + years;
    var strDay = this.getDate();
    var strMonth = this.getMonth()+1;
    if(strMonth<10)
    {
        strMonth="0"+strMonth;
    }

    if(strDay<10)
    {
        strDay = "0" + strDay;
    }

    var datastr = strYear + "-" + strMonth + "-" + strDay;
    return datastr;
}

/**
 * n個月後(前)今天，n若未正整數則維n年後，反之則為n日前
 * @param int months
 */
Date.prototype.addMonths = function(months)
{
    this.setMonth(this.getMonth() + months);
    var strYear = this.getFullYear();
    var strMonth = this.getMonth() + 1;
    var strDay = this.getDate();

    var datastr = strYear + '-' +
        (strMonth < 10 ? '0' : '') + strMonth + '-' +
        (strDay < 10 ? '0' : '') + strDay;

    return datastr;
}

/**
 * n日後(前)今天，n若未正整數則維n日後，反之則為n日
 * @param {*} days
 */
Date.prototype.addDays = function(days)
{
    this.setDate(this.getDate() + days);
    return this;
}

/**
 * 該年分第一天時間日期
 */
Date.prototype.yearFirstDay = function()
{
    var year = this.getFullYear();
    date = new Date(year, 0, 1);
    return date;
}

/**
 * 當月第一天時間日期
 */
Date.prototype.monthFirstDay = function()
{
    this.setDate(1);
    return this;
}

/**
 * 當月最後一天時間日期
 */
Date.prototype.monthFinalDay = function()
{
    this.setMonth(this.getMonth() + 1);
    this.setDate(-1);
    return this;
}

/**
 * 上個月第一天時間日期
 */
Date.prototype.previousMonthFirstDay = function()
{
    var year = this.getFullYear();
    var month = this.getMonth();
    var date = new Date(year, month - 1, 1);
    return date;
}

/**
 * 上個月最後一天時間日期
 */
Date.prototype.previousMonthFinalDay = function()
{
    var year = this.getFullYear();
    var month = this.getMonth();
    var date = new Date(year, month, 0);
    return date;
}
