<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $links string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
	
		<link href='http://fonts.googleapis.com/css?family=Tangerine|Roboto+Condensed' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="http://callu.net/favicon.ico">
		<META NAME="robots" content="index,follow">
		<META NAME="description" CONTENT="GigsPlans shows you Artists/Bands plans for the future in the world">
		<META NAME="keywords" CONTENT="gigsplans,gig,plannings,booker,broker,Bookings,Worldwide,Artist,celebrity,booking,book,hire,band,musician, Artistguide,coperate entertainment,agency,private parties,fairs,festivals,radio events,promotions,corporate events,world,wide,concerts,special events,festivals,trade shows,fund raisers,boking">
		
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<script type="text/javascript">stLight.options({publisher:'8e4be83b-97eb-4093-8ad3-bbf2fb21a722'});</script>
		
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-9306013-5']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
		
		<?php $this->head(); ?>
	</head>
<body>

<?php $this->beginBody() ?>
<?php if (!isset($this->params['breadcrumbs'])) { ?>
<center>
	<div style="background-image:url(/img/bg.jpg);padding:0px;width:960px;height:230px;border:0px solid black;">
		<table border="0">
			<tr align="left" valign="top">            
				<td width="960" valign="top" align="center">
					<p style="font-family:Roboto Condensed;font-size:260%;color:FFFFFF">Worldwide April 2015 <span class="st_sharethis_button" displayText="ShareThis"></span></p>
					<form name="form4">
						<select style="font-size:36px;color:#006699;font-family:Roboto Condensed;background-color:#FFFF99;" 
								name="menu" onChange="location=document.form4.menu.options[document.form4.menu.selectedIndex].value;">
							<option value=''>Select Other Continent</option>
							<option value="/africa/2015">Africa</option>
							<option value="/asia/2015">Asia</option>
							<option value="/australia/2015">Australia</option>
							<option value="/europe/2015">Europe</option>
							<option value="/northamerica/2015">North America</option>
							<option value="/southamerica/2015">South America</option>
						</select>
					</form>
				</td>
			</tr>
			<?php if (isset($this->params['headerLinks'])) foreach ($this->params['headerLinks'] as $year => $yearLinks): $prefix = $yearLinks[0];?>
			<tr>
				<td>
					<div class="hovermenu nav_bar">
						<ul>
							<li class="navhome"><a href="/<?= $prefix ?>/<?=$year ?>/" title="Year <?=$year ?> in <?=ucfirst($prefix)?>"><span>Year <?= $year ?></span></a></li>
							<?php foreach ($yearLinks[1] as $link):?>
								<li><a href="<?= $link['href'] ?>" title="<?= $link['title'] ?>"><span><?= $link['text'] ?></span></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</center> <?php } ?>
   <div class="wrap">
	   <?php if (isset($this->params['breadcrumbs'])) : ?>
	   <div>
	   <?php
            NavBar::begin([
                'brandLabel' => 'ArtistPlans.com',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
			
			$items = [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],		
                   // ['label' => 'Contact', 'url' => ['/site/contact']]
			];
			
			if (!Yii::$app->user->isGuest) {
				$items[] = ['label' => 'Admin panel', 'url' => ['/admin']];
				$items[] = ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']];
			}
			else {
				$items[] = ['label' => 'Login', 'url' => ['/site/login']] ;
			}
			
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $items,
            ]);
            NavBar::end(); 
		?>
		</div>
	   <nav style="padding-top: 60px;">
		<?=Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
		]); ?>
	   </nav>
        <?php endif; ?>
	   
        <div class="container">  
			<?= $content ?>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
			<p>
				<a href="http://www.gigsplans.com/contact.html" title="Contact us here, one of our staff will call you back within 15 minutes" Target="_blank">Contact</a>
			</p>
			<p style="font-family:Roboto Condensed;font-size:100%;color:000000">
				Powered by <a href="http://www.callu.net/" title="Intelligent booking assistance service, one of our staff will call you back within 15 minutes" Target="_blank"><img src="http://www.callu.net/im/callyounetv102x24.png" width="102" height="24" alt="Worldwide booker broker for Artists/Bands"></a> Unique Visitors Worldwide Worldbooking.net Follow us <a href="http://www.twitter.com/artistguide" TARGET="_blank" title="FOLLOW US ON TWITTER"><img src="http://www.callu.net/im/twitterv103x24.png" width="103" height="24" alt="WELCOME TO OUR TWITTER"></a>&nbsp;<a href="https://www.facebook.com/Callyounetcom" TARGET="_blank" title="CallYouNet Worldbooking.net FACEBOOK">
				<img src="http://www.callu.net/im/facebookv112x24.png" width="112" height="24" alt="ON FACEBOOK">
			</a>
			</p>
			<img src="http://flagcounter.com/count/DWJy/bg=FFFFFF/txt=000000/border=FFFFFF/columns=8/maxflags=24/viewers=3/labels=1/" alt="free counters" border="0">

            <p class="pull-left">&copy; ArtistPlans.com <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
