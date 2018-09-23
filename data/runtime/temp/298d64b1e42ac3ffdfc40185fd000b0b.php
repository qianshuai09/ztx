<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:52:"themes/admin_simpleboot3/admin/active/addactive.html";i:1537677477;s:85:"/www/web/ztx_hfxyzq_cn/public_html/public/themes/admin_simpleboot3/public/header.html";i:1533800384;}*/ ?>
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
        <li ><a href="<?php echo url('Active/active'); ?>">活动列表</a></li>
        <li class="active"><a href="<?php echo url('Active/addactive'); ?>">添加活动</a></li>
    </ul>

    <form action="<?php echo url('Active/addactivePost'); ?>" method="post" id="form" class="form-horizontal  margin-top-20">
        <div class="row">
            <div class="col-md-9">
                <table class="table table-bordered">
                    
                    <tr>
                        <th>活动名称</th>
                        <td >
                            <input class="form-control" type="text" name="pname"
                                   id="pname" required value="" placeholder=""/>
                        </td>
                    </tr>
                    <tr>
                        <th>活动标题</th>
                        <td >
                            <input class="form-control" type="text" name="ptitle"
                                   id="ptitle" required value="" placeholder=""/>
                        </td>
                    </tr>
                    <tr>
                    <th>活动时间</th>
                        <td >
                           <input class="form-control" type="text" name="atime"
                                   id="atime" required value="" placeholder=""/>
                        </td>
                       
                    </tr>
                    <tr>
                        <th>活动地点</th>
                        <td>
                           <input class="form-control" type="text" name="alocation"
                                   id="alocation" required value="" placeholder=""/>
                        </td>
                    </tr>
                    <tr>
                        <th>活动备注</th>
                        <td><input class="form-control" type="text" name="abeizhu"
                                   id="abeizhu" required value="" placeholder=""/></td>
                    </tr>
                    <tr>
                        <th>活动详情图</th>
                        <td>
                            <ul id="photos" class="pic-list list-unstyled form-inline"></ul>
                            <a href="javascript:uploadMultiImage('图片上传','#photos','photos-item-tpl');"
                               class="btn btn-default btn-sm">选择图片</a>
                        </td>
                    </tr>
                </table>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('ADD'); ?></button>
                        <a class="btn btn-default" href="<?php echo url('active/active'); ?>"><?php echo lang('BACK'); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <table class="table table-bordered">
                    <tr>
                        <th><b>活动列表图</b></th>
                    </tr>
                    <tr>
                        <td>
                           <div style="text-align: center;">
                                <input type="hidden" name="pimg" id="thumbnail" value="">
                                <a href="javascript:uploadOneImage('图片上传','#thumbnail');">
                                    <img src="/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png"
                                         id="thumbnail-preview"
                                         width="135" style="cursor: pointer"/>
                                </a>
                                <input type="button" class="btn btn-sm btn-cancel-thumbnail" value="取消图片">
                            </div>
                        </td>
                    </tr>
                    
                </table>
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
