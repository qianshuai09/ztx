<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:48:"themes/admin_simpleboot3/admin/custom/index.html";i:1534491066;s:85:"/www/web/ztx_hfxyzq_cn/public_html/public/themes/admin_simpleboot3/public/header.html";i:1533800384;}*/ ?>
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

.label-write{
    background-color:blue ;
}

.label-gray{
    background-color: gray;
}

.labe-success{
    background-color: #5cb85c;
}

</style>
</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo url('Custom/index'); ?>">客户列表</a></li>

    </ul>
    <div class="well form-inline margin-top-20" >
        客户:
        <input type="text" class="form-control" name="keyword" id="key" style="width: 200px;"
               value="<?php echo (isset($keyword) && ($keyword !== '')?$keyword:''); ?>" placeholder="请输入昵称或真实姓名">
        <button class="btn btn-primary" id="so">搜索</button>
    </div>
    <form class="js-ajax-form" method="post">
       
        
        <?php 
       
       $istatus = array("0"=>"<span class='label label-write radius'>未提交</span>", "1"=>"<span class='label label-error radius'>待审核</span>","2"=>"<span class='label labe-success radius'>审核成功</span>","3"=>"<span class='label label-gray radius'>审核失败</span>");
       ?>
        <table class="table table-hover table-bordered table-list">
            <thead>
            <tr>
                <th >ID</th>
                <th>微信昵称</th>
                <th>微信头像</th>
                <th>真实姓名</th>
                <th>身份证号</th>
                <th>学生证号</th>
                <th>身份证正面</th>
                <th>身份证反面</th>
                <th>学生证照片</th>
                <th>社团证照片</th>
                <th>认证时间</th>
                <th>审核状态</th>
                <th >操作</th>
            </tr>
            </thead>

         <?php if(is_array($custom) || $custom instanceof \think\Collection || $custom instanceof \think\Paginator): if( count($custom)==0 ) : echo "" ;else: foreach($custom as $key=>$vo): ?>
            <tr>
                <td><?php echo $vo['uid']; ?></td>
                <td><?php echo $vo['wx_name']; ?></td>
                <td><img width="25" height="25" src="<?php echo $vo['wx_img_url']; ?>"></td>
                <td><?php echo $vo['name']; ?></td>
                <td><?php echo $vo['idnumber']; ?></td>
                <td><?php echo $vo['bnumber']; ?></td>
                <td><a href="<?php echo cmf_get_image_preview_url($vo['front']); ?>">查看图片</a></td>
                <td><a href="<?php echo cmf_get_image_preview_url($vo['back']); ?>">查看图片</a></td>
                <td><a href="<?php echo cmf_get_image_preview_url($vo['stuphoto']); ?>">查看图片</a></td>
                <td><a href="<?php echo cmf_get_image_preview_url($vo['clubphoto']); ?>">查看图片</a></td>
                <td><?php echo $vo['create_time']; ?></td>
               
                <?php if($vo['status']==1): ?>
                <td><a href="#" onclick="editID('<?php echo url('custom/checkid',array('id'=>$vo['uid'])); ?>')" style="text-decoration: none;"><?php echo $istatus[$vo['status']]; ?></a></td>
                <?php else: ?>
                <td><?php echo $istatus[$vo['status']]; ?></td>
                <?php endif; ?>
                <td>
                    <a href="<?php echo url('custom/delete',array('id'=>$vo['uid'])); ?>" class="js-ajax-delete"><?php echo lang('DELETE'); ?></a>
                </td>
            </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </table>

        <div class="pagination"><?php echo $custom->render(); ?></div>
    </form>
</div>
<script src="/static/js/admin.js"></script>
<script src="/static/layer/layer.js"></script>
<script>

function editID(url){
    
  layer.open({
  title:'信息审核',
  type: 2,
  area: ['600px', '700px'], //宽高
  content: url
});

}


$("body").on('click','#so',function(){
    
    var key = $("#key").val();
    layer.open({
        title:'客户信息',
        type:2,
        area: ['600px', '700px'],
        content:'/index.php/admin/custom/select?key='+key
    })
})
 




</script>

</body>
</html>