<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:50:"themes/admin_simpleboot3/admin/custom/checkid.html";i:1534491491;s:85:"/www/web/ztx_hfxyzq_cn/public_html/public/themes/admin_simpleboot3/public/header.html";i:1533800384;}*/ ?>
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
</head>
<body>
<div class="wrap js-check-wrap">
    <div class="row margin-top-20">

        <div class="col-md-6">
          
                <div class="tab-content">
                    <div class="tab-pane active" id="A">

               <table class="table table-hover table-bordered table-list">
                    <tr>
                       <td width="100px"> <label for="input-name"><span class="form-required">*</span>真实姓名</label></td>
                       <td><?php echo $custom['name']; ?></td>
                   </tr>
                   <tr>
                       <td width="100px"> <label for="input-name"><span class="form-required">*</span>身份证号</label></td>
                       <td><?php echo $custom['idnumber']; ?></td>
                   </tr>
                   
                   <tr>
                       <td > <label for="input-name"><span class="form-required">*</span>身份证正面</label></td>
                       <td><img src="<?php echo $custom['front']; ?>" width="100%" height="200px"></td>
                       
                    </tr>
                   <tr>
                       <td> <label for="input-name"><span class="form-required">*</span>身份证背面</label></td>
                       <td><img src="<?php echo $custom['back']; ?>" width="100%" height="200px"></td>
                   </tr>
                   <tr>
                       <td> <label for="input-name"><span class="form-required">*</span>学生证</label></td>
                       <td><img src="<?php echo $custom['stuphoto']; ?>" width="100%" height="200px"></td>
                   </tr>
                     <tr>
                       <td> <label for="input-name"><span class="form-required">*</span>社团工作证</label></td>
                       <td><img src="<?php echo $custom['clubphoto']; ?>" width="100%" height="200px"></td>
                   </tr>
                   <tr>
                       <td colspan="2" align="center"><button type="button" id="pass" class="btn btn-primary js-ajax-submit">认证通过</button>&nbsp;&nbsp;
                       <a class="btn btn-default" href="#" id="back">认证驳回</a></td>
                   </tr>
               </table>
                    </div>
                </div>
           
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/js/admin.js"></script>
<script src="/static/layer/layer.js"></script>
<script>

 var uid = <?php echo $custom['uid']; ?>;
    
    $("body").on('click','#pass',function(){
        
        $.ajax({
            
            url:"<?php echo url('custom/passId'); ?>",
            type:'post',
            data:{
                id:uid
            },
            success:function(data){
                
          if(data==1){
            layer.alert("认知通过成功！",function(){
            parent.layer.close(layer.index);
            window.parent.location.reload();
        })
          }else{
              layer.msg("认证通过失败！");
          }
           
            }
        })
        
       
    })
    
     $("body").on('click','#back',function(){
         
         $.ajax({
             
             url:"<?php echo url('custom/backId'); ?>",
             type:'POST',
             data:{
               id:uid  
             },
             success:function(data){
           if(data==1){
        layer.alert("认知驳回成功！",function(){
            
            parent.layer.close(layer.index);
            window.parent.location.reload();
        })
                 }else{
                     layer.msg("认证驳回失败！");
                 }
             }
         })
        
     
    })
    
    
</script>
</body>
</html>