<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:46:"themes/admin_simpleboot3/admin/join/index.html";i:1536138064;s:85:"/www/web/ztx_hfxyzq_cn/public_html/public/themes/admin_simpleboot3/public/header.html";i:1533800384;}*/ ?>
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
    background-color: blue;
}
</style>
</head>
<body>

<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo url('join/index'); ?>">加入我们列表</a></li>
        
    </ul>
  <!--  <form class="well form-inline margin-top-20" method="post" action="<?php echo url('AdminPage/index'); ?>">
        标题:
        <input type="text" class="form-control" name="keyword" style="width: 200px;"
               value="<?php echo (isset($keyword) && ($keyword !== '')?$keyword:''); ?>" placeholder="请输入关键字">
        <button class="btn btn-primary">搜索</button>
    </form>-->
    <form class="js-ajax-form" method="post">

        
        <?php 
       
       $ostatus = array("0"=>"<span class='label label-error radius'>未推荐</span>","1"=>"<span class='label label-success radius'>已推荐</span>");
       
       ?>
       
        <table class="table table-hover table-bordered table-list">
            <thead>
            <tr>
              
                <th width="10">ID</th>
                <th >姓名</th>
                <th>支付宝号</th>
                <th>手机号</th>
                <th>学校</th>
                <th>QQ号</th>
                <th>微信号</th>
                <th>个人免冠照</th>
                <th>身份证正面</th>
                <th>申请时间</th>
               
                <th>操作</th>
            </tr>
            </thead>

                 <?php if(is_array($join) || $join instanceof \think\Collection || $join instanceof \think\Paginator): if( count($join)==0 ) : echo "" ;else: foreach($join as $key=>$vo): ?>
                <tr>
                   
                    <td><?php echo $vo['jid']; ?></td>
                
                    <td><?php echo $vo['jname']; ?></td>
                    
                    <td><?php echo $vo['jidnum']; ?></td>
                    <td><?php echo $vo['phone']; ?></td>
                    <td><?php echo $vo['school']; ?></td>
                    <td><?php echo $vo['card']; ?></td>
                    <td><?php echo $vo['wxnum']; ?></td>
                    <td><a href="<?php echo cmf_get_image_url($vo['photo']); ?>" target="_blank">查看图片</a></td>
                    <td><a href="<?php echo cmf_get_image_url($vo['idimg']); ?>" target="_blank">查看图片</a></td>
                    <td><?php echo $vo['create_time']; ?></td>
                  
                      <td>
                        
                         <a href="<?php echo url('join/delete',array('id'=>$vo['jid'])); ?>" class="js-ajax-delete"><?php echo lang('DELETE'); ?></a>
                    </td>
                </tr>
                 <?php endforeach; endif; else: echo "" ;endif; ?>
            <tfoot>

            </tfoot>
        </table>
        <div class="pagination" ><?php echo $join->render(); ?></div>
    </form>
</div>
<script src="/static/js/admin.js"></script>
<script src="/static/layer/layer.js"></script>
<script>

function recom(url){
$.ajax({
    url:url,
    type:'GET',
    success:function(data){
       if(data ==1){
         layer.alert('不推荐成功!',function(){
              window.location.reload();
         })
       }
    }
})

}

function reco(url){
$.ajax({
    url:url,
    type:'GET',
    success:function(data){
      if(data==1){
         layer.alert('推荐成功!',function(){
             window.location.reload();
         })
      }
    }
})
}
 

</script>
</body>
</html>