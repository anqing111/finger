//ajax请求
function getAJAX(jsonData,fun,url){
    $.ajax({
        url: "index.php?r=web/"+url,
        data: jsonData,
        type: "post",
        dataType:'json',
        success: function (backdata) {
            fun(backdata);
        },error: function (error) {
            fun({"flag":false});
        }
    });
}
//ajax表单请求
function getFormAjax(frm1,jsonData,fun){
    $(frm1).ajaxSubmit({
        type : 'post', // 提交方式 get/post
        url : "?r=web/Ajax/Upload", // 需要提交的 url
        data : jsonData,
        success : function(data) {
            var data = JSON.parse(data);
            fun(data);
        }
    });
}
//手机格式验证
function validatemobile(mobile){

    var data = {};
    data["code"] = 1;

    if(mobile.length==0)
    {
        data["msg"] = "请输入手机号";
        return data;
    }
    if(mobile.length!=11)
    {
        data["msg"] = "您输入的手机号格式有误";
        return data;
    }
    var myreg =/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|17[0-9]|19[0-9])\d{8}$/;
    if(!myreg.test(mobile))
    {
        data["msg"] = "您输入的手机号格式有误";
        return data;
    }

    data["code"] = 0;
    return data;
}
//注册电话格式验证
function verifyRegistPhone(mobile){

    var data = {};
    data["code"] = 1;

    if(mobile.length==0)
    {
        data["msg"] = "注册电话不能为空";
        return data;
    }
    var regTelephone = /^((([0-9]{3,4})|([0-9]{3,4}-))?[0-9]{7,14})|(1[23456789]\d{9})$/; // 校验固话
    if(!(regTelephone.test(mobile)))
    {
        data["msg"] = "注册电话只能为座机或者手机号";
        return data;
    }

    data["code"] = 0;
    return true;
}

//设置密码格式验证
function validatepass(loginPass)
{
    var data = {};
    data["code"] = 1;

    if(loginPass.length==0)
    {
        data["msg"] = "密码不能为空";
        return data;
    }
    if(loginPass.length > 15 || loginPass.length < 6)
    {
        data["msg"] = "请输入6-15位数字或字母密码";
        return data;
    }
    var myreg =/^[0-9A-Za-z]{6,15}$/;
    if(!myreg.test(loginPass))
    {
        data["msg"] = "请输入6-15位数字或字母密码";
        return data;
    }

    data["code"] = 0;

    return data;
}

//邮箱格式验证
function validateemail(sMailBox)
{
    var data = {};
    data["code"] = 1;

    var myreg = new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$"); //正则表达式
    if(!myreg.test(sMailBox))
    {
        data["msg"] = "邮箱格式不正确";
        return data;
    }

    data["code"] = 0;

    return data;
}

//判断是否为数字
function checkRate(nubmer,type) {
    if(type == 'float'){
        var re = /^[0-9]+.?[0-9]*$/;
    }
    if(type == 'int'){
        var re = /^[1-9]+[0-9]*]*$/;
    }
    return re.test(nubmer);
}

//判断是否为数字并且保留一位数字
function checkPercent(number)
{
    var data = {};
    data["code"] = 1;
    var myreg =/^(([0-9]|([1-9][0-9]{0,1}))((\.[0-9]{1})?))$/;
    if(! myreg.test(number))
    {
        return data;
    }

    data["code"] = 0;

    return data;
}

//判断是否为数字并且保留2位数字
function checkPercent2(number)
{
    var data = {};
    data["code"] = 1;
    var myreg =/^(([1-9]|([1-9][0-9]{0,9}))((\.[0-9]{1,2})?))$/;
    if(! myreg.test(number))
    {
        return data;
    }

    data["code"] = 0;

    return data;
}

//判断是否为正整数
function checkCount(number)
{
    var data = {};
    data["code"] = 1;
    var myreg =/^([1-9][0-9]{0,9})$/;
    if(! myreg.test(number))
    {
        return data;
    }

    data["code"] = 0;

    return data;
}

//判断是否在前面加0
function getNow(s) {
    return s < 10 ? '0' + s: s;
}

//获取当前时间
function getDateTime()
{
    var myDate = new Date();

    var year=myDate.getFullYear();        //获取当前年
    var month=myDate.getMonth()+1;   //获取当前月
    var date=myDate.getDate();            //获取当前日


    var h=myDate.getHours();              //获取当前小时数(0-23)
    var m=myDate.getMinutes();          //获取当前分钟数(0-59)
    var s=myDate.getSeconds();

    var now=year+'-'+getNow(month)+"-"+getNow(date)+" "+getNow(h)+':'+getNow(m)+":"+getNow(s);
    return now;
}

