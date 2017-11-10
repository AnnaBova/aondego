<?php 
use yii\helpers\Html;
use backend\assets\AdminAppAsset;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
//use yii\helpers\Html;
$menu = true;
?>

    <?php 
    AdminAppAsset::register($this);
    
    
    $this->beginPage() ?>



<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php 
        
        $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->beginBody() ;
        
        ?>
        
        <div class="wrapper">
    <header class="main-header">
        <a href="<?php echo Yii::$app->urlManager->createUrl('/dashboard')?>" class="logo">
            <!-- LOGO -->
            Admin Module
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <?= Html::img(Yii::$app->urlManager->baseUrl.'/images/flags/au.png',  ['class' => 'img-circle']) ?>
                                            </div>
                                            <h4>
                                                Sender Name
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Message Excerpt</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                    ...
                                </ul>
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="ion ion-ios-people info"></i> Notification title
                                        </a>
                                    </li>
                                    ...
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    ...
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?= Html::img(Yii::$app->urlManager->baseUrl.'/images/flags/ua.png', ['class' => 'user-image']) ?>

                            <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <?= Html::img(Yii::$app->urlManager->baseUrl.'/images/flags/ua.png', ['class' => 'user-image']) ?>

                                <p>
                                    <?= Yii::$app->user->identity->username ?> - Merchant
                                    <small>Member since Nov. <?= Yii::$app->user->identity->date_created ?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Messages</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Warnings</a>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo Yii::$app->urlManager->createUrl('profile')?>" class="btn btn-default btn-flat"><?= Yii::t('basicfield','Profile')?></a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo Yii::$app->urlManager->createUrl('/login/logout')?>" class="btn btn-default btn-flat"><?= Yii::t('basicfield','Sign out')?></a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <select class="form-control" name="lang" id="lang">
                            <?php 
                            
                                $cookies = Yii::$app->request->cookies;
                                $current_language = $cookies->getValue('language');
                                
                                echo $current_language;
                                //exit;

                            $languages = \common\models\Language::find()->all();
                            foreach ($languages as $language){
                            ?>
                            <option value="<?php echo $language->code;?>" 
                                <?php if(isset($current_language) && $current_language == $language->code){ echo 'selected="selected"';}?> ><?php echo $language->name;?></option>
                            <?php }?>
                            
                            
							
                        </select>
                    </li>
                </ul>
            </div>
            
            
        </nav>
    </header>
    <!--END header_wrap-->
    <div class="main-sidebar">
        <!-- Inner sidebar -->
        <div class="sidebar">
            <!-- user panel (Optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <?php echo Html::img(Yii::$app->urlManager->baseUrl.'/images/flags/au.png') ?>
                </div>
                <div class="pull-left info">
                    <p><?= Yii::$app->user->identity->username ?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> <?= Yii::t('basicfield','Online')?></a>
                </div>
            </div>
            <!-- /.user-panel -->

            <?php $menuItems = \backend\components\AdminHelper::adminMenu();
            /*echo '<pre>';
            print_r($menuItems);exit;*/
            
            echo Menu::widget(
                $menuItems
            );
            //$this->widget('zii.widgets.CMenu', $menuItems); ?>

        </div>
        <!-- /.sidebar -->
    </div>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="breadcrumbs">
                <div class="inner">
                    <?php 
                    
                    echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
                    
//                    $this->widget('booster.widgets.TbBreadcrumbs', array(
//                        'links' => $this->breadcrumbs,
//                    )); ?>
                </div>
            </div>
            <!--breadcrumbs-->
        </section>

        <section class="content">
            <?php if (($this->context->menu)) {
                echo Html::a(Yii::t('basicfield', 'Create'), ['create'], ['class' => 'btn btn-default']);
                echo '&nbsp';
                echo Html::a(Yii::t('basicfield', 'List'), ['index'], ['class' => 'btn btn-default']);
            }?>
            <?php echo $content; ?>
            
        </section>

        <!--INNER-->
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.0
        </div>
        
        <?php $siteName  = \common\models\Option::getValByName('website_title');?>
        <strong>Copyright &copy; <?= date('Y') ?>
            <a href="http://strafun.com">
                <?php echo $siteName?>
            </a>.</strong> All rights
        reserved.
    </footer>
</div>
        
        <?php 
        
$this->registerJs("
    var AdminLTEOptions = {
            //Enable sidebar expand on hover effect for sidebar mini
            //This option is forced to true if both the fixed layout and sidebar mini
            //are used together
            sidebarExpandOnHover: true,
            //BoxRefresh Plugin
            enableBoxRefresh: true,
            //Bootstrap.js tooltip
            enableBSToppltip: true
        };
        
$('#lang').on('change', function(ev){
    console.log('i am here');
        var code = $(this).val();
        console.log(code);
        $.ajax({
            type : 'post',
            url : '".Yii::$app->urlManager->createAbsoluteUrl('dashboard/language')."',
            data : {code : code},
            success :  function(response){
                if(response == true){
                    location.reload(); 
                }
            
            }
        
            })
        
        })
        ");
        ?>

        
         <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ;

?>