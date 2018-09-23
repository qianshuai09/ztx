<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"themes/admin_simpleboot3/admin/apply/reply.html";i:1536645930;s:85:"/www/web/ztx_hfxyzq_cn/public_html/public/themes/admin_simpleboot3/public/header.html";i:1533800384;}*/ ?>
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

<style type="text/css">
    .pic-list li {
        margin-bottom: 5px;
    }
    
    .textinput{

 
    width:100px;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;

    }


</style>
<script type="text/html" id="photos-item-tpl">
    <li id="saved-image{id}">
        <input id="photo-{id}" type="hidden" name="photo_urls[]" value="{filepath}">
        <input class="form-control" id="photo-{id}-name" type="text" name="photo_names[]" value="{name}"
               style="width: 200px;" title="图片名称">
        <img id="photo-{id}-preview" src="{url}" style="height:36px;width: 36px;"
             onclick="imagePreviewDialog(this.src);">
        <a href="javascript:uploadOneImage('图片上传','#photo-{id}');">替换</a>
        <a href="javascript:(function(){$('#saved-image{id}').remove();})();">移除</a>
    </li>
</script>
</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        
        <li class="active"><a href="#">申请回复</a></li>
    </ul>

    <form action="<?php echo url('Apply/replyPost'); ?>" method="post" id="form" class="form-horizontal js-ajax-form margin-top-20">
        <div class="row">
            <div class="col-md-9">
                <table class="table table-bordered">
                    
                    <tr>
                        <th>回复内容</th>
                        <td >
                            <input class="form-control" type="text" name="ocontent"
                                   id="pname" required value="<?php echo $order['ocontent']; ?>" placeholder=""/>
                            <input type="hidden" name="oid" value="<?php echo $order['oid']; ?>">
                        </td>
                    </tr>
                   
                    <tr>
                        <th>回复证书图片</th>
                        <td>
                         <ul id="photos" class="pic-list list-unstyled form-inline">
                                <?php if(!(empty($img) || (($img instanceof \think\Collection || $img instanceof \think\Paginator ) && $img->isEmpty()))): if(is_array($img) || $img instanceof \think\Collection || $img instanceof \think\Paginator): if( count($img)==0 ) : echo "" ;else: foreach($img as $key=>$vo): $img_url=cmf_get_image_preview_url($vo['url']); ?>
                                        <li id="saved-image<?php echo $key; ?>">
                                            <input id="photo-<?php echo $key; ?>" type="hidden" name="photo_urls[]"
                                                   value="<?php echo $vo['url']; ?>">
                                            
                                            <img id="photo-<?php echo $key; ?>-preview"
                                                 src="<?php echo cmf_get_image_preview_url($vo['url']); ?>"
                                                 style="height:36px;width: 36px;"
                                                 onclick="parent.imagePreviewDialog(this.src);">
                                            <a href="javascript:uploadOneImage('图片上传','#photo-<?php echo $key; ?>');">替换</a>
                                            <a href="javascript:(function(){$('#saved-image<?php echo $key; ?>').remove();})();">移除</a>
                                        </li>
                                    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                            </ul>
                            <a href="javascript:uploadMultiImage('图片上传','#photos','photos-item-tpl');"
                               class="btn btn-sm btn-default">选择图片</a>
                        </td>
                    </tr>
                </table>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary js-ajax-submit">回复</button>
                        <a class="btn btn-default" href="<?php echo url('active/active'); ?>"><?php echo lang('BACK'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="/static/js/jquery.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/admin.js"></script>
<script type="text/javascript" src="/static/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/static/js/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript">


    //编辑器路径定义
    var editorURL = GV.WEB_ROOT;

    $(function () {

        editorcontent = new baidu.editor.ui.Editor({initialFrameHeight:500,initialFrameWidth:'100%' });
        editorcontent.render('content');

        try {
            editorcontent.sync();
        } catch (err) {
        }
        editcont = new baidu.editor.ui.Editor({initialFrameHeight:500,initialFrameWidth:'100%' });
        editcont.render('content1');
        try {
            editcont.sync();
        } catch (err) {
        }
        
        
        
        $('.btn-cancel-thumbnail').click(function () {
            $('#thumbnail-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail').val('');
        });
        
          $('.btn-cancel-thumbnai2').click(function () {
            $('#thumbnai2-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnai2').val('');
        });

    });
    
     // bootstrap日期选择器
    var bootstrapDateInput = $("input.js-bootstrap-date")
    if (bootstrapDateInput.length) {
        Wind.css('bootstrapDatetimePicker');
        Wind.use('bootstrapDatetimePicker', function () {
            bootstrapDateInput.datetimepicker({
                language: 'zh-CN',
                format: 'yyyy-mm-dd',
                minView: 'month',
                todayBtn: 1,
                autoclose: true
            });
        });
    }

    // bootstrap日期选择器日期+时间选择器
    var bootstrapDateTimeInput = $("input.js-bootstrap-datetime");
    if (bootstrapDateTimeInput.length) {
        Wind.css('bootstrapDatetimePicker');
        Wind.use('bootstrapDatetimePicker', function () {
            bootstrapDateTimeInput.datetimepicker({
                language: 'zh-CN',
                format: 'yyyy-mm-dd hh:ii',
                todayBtn: 1,
                autoclose: true
            });
        });
    }
    
    
    
 



  
</script>
</body>
</html>
