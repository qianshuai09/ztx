<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:49:"themes/admin_simpleboot3/admin/custom/select.html";i:1534491874;s:85:"/www/web/ztx_hfxyzq_cn/public_html/public/themes/admin_simpleboot3/public/header.html";i:1533800384;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->


    <link href="/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        form .input-order {
            margin-bottom: 0px;
            padding: 0 2px;
            width: 42px;
            font-size: 12px;
        }

        form .input-order:focus {
            outline: none;
        }

        .table-actions {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 0px;
        }

        .table-list {
            margin-bottom: 0px;
        }

        .form-required {
            color: red;
        }
    </style>
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/",
            WEB_ROOT: "/",
            JS_ROOT: "static/js/",
            APP: '<?php echo \think\Request::instance()->module(); ?>'/*当前应用名*/
        };
    </script>
    <script src="/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/static/js/wind.js"></script>
    <script src="/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
    <script>
        Wind.css('artDialog');
        Wind.css('layer');
        $(function () {
            $("[data-toggle='tooltip']").tooltip({
                container:'body',
                html:true,
            });
            $("li.dropdown").hover(function () {
                $(this).addClass("open");
            }, function () {
                $(this).removeClass("open");
            });
        });
    </script>
    <?php if(APP_DEBUG): ?>
        <style>
            #think_page_trace_open {
                z-index: 9999;
            }
        </style>
    <?php endif; ?>
<style>
          .label-error {
    background-color: red;
}

    .label-fa{
     background-color: blue;
}

</style>



</head>
<body>
    
      <?php 
       
       $ostatus = array("0"=>"<span class='label label-error radius'>未支付</span>","1"=>"<span class='label label-success radius'>已支付</span>");
        $sstatus = array("0"=>"<span class='label label-error radius'>未发送</span>","1"=>"<span class='label label-success radius'>已发送</span>");
        $cstatus=array("1"=>"<span class='label label-fa radius'>自发布</span>","2"=>"<span class='label label-success radius'>智游宝</span>");
       
       ?>
<div class="wrap js-check-wrap">
    <div class="row margin-top-20">

        <div class="col-md-6">
          
                <div class="tab-content">
                    <div class="tab-pane active" id="A">

                   <table class="table table-hover table-bordered table-list">
                   <tr>
                       <td width="100px"> <label for="input-name"><span class="form-required">*</span>微信昵称</label></td>
                       <td><?php echo $custom['wx_name']; ?></td>
                   </tr>
                   <tr>
                  <tr>
                        <td width="100px"> <label for="input-name"><span class="form-required">*</span>微信头像</label></td>
                       <td><img width="25" height="25" src="<?php echo $custom['wx_img_url']; ?>"></td>
                  </tr>
                   <tr>
                        <td width="100px"> <label for="input-name"><span class="form-required">*</span>真实姓名</label></td>
                       <td><?php echo $custom['name']; ?></td>
                  </tr>
                   <tr>
                        <td width="100px"> <label for="input-name"><span class="form-required">*</span>身份证号码</label></td>
                       <td><?php echo $custom['idnumber']; ?></td>
                  </tr>
                     <tr>
                        <td width="100px"> <label for="input-name"><span class="form-required">*</span>学生证号码</label></td>
                       <td><?php echo $custom['bnumber']; ?></td>
                  </tr>
                   <tr>
                        <td width="100px"> <label for="input-name"><span class="form-required">*</span>身份证图片</label></td>
                       <td><img src="<?php echo $custom['front']; ?>" width="100%" height="200px">
                       <img src="<?php echo $custom['back']; ?>" width="100%" height="200px">
                       </td>
                       
                  </tr>
                                     <tr>
                        <td width="100px"> <label for="input-name"><span class="form-required">*</span>其他证件</label></td>
                       <td><img src="<?php echo $custom['stuphoto']; ?>" width="100%" height="200px">
                       <img src="<?php echo $custom['clubphoto']; ?>" width="100%" height="200px">
                       </td>
                       
                  </tr>
                    
                         <tr>
                        <td width="100px"> <label for="input-name"><span class="form-required">*</span>入驻时间</label></td>
                       <td><?php echo $custom['create_time']; ?></td>
                  </tr>
                  
               </table>
                    </div>
                </div>
           
        </div>
    </div>
</div>
<script src="/static/js/admin.js"></script>
<script src="/static/layer/layer.js"></script>
<script>

function editID(url){
    
  layer.open({
  title:'身份证审核',
  type: 2,
  area: ['600px', '700px'], //宽高
  content: url
});

}

function editBank(urls){
    
  layer.open({
  title:'银行卡审核',
  type: 2,
  area: ['600px', '700px'], //宽高
  content: urls
});
}
 




</script>

</body>
</html>