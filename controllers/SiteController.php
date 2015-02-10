<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\ArtistSearch;
use app\models\ArtistPlanSearch;
use yii\db\Query;


class SiteController extends Controller
{
	
	private $months = [
		'jan' => 1,
		'january' => 1,
		'feb' => 2,
		'february' => 2,
		'march' => 3,
		'april' => 4,
		'may' => 5,
		'june' => 6,
		'july' => 7,
		'august' => 8,
		'september' => 9,
		'october' => 10,
		'november' => 11,
		'december' => 12	
	];
	
	private function parseMonth($month) {
		if (is_int($month)) return intval($month);
		if (is_string($month)) {
			if (array_key_exists(strtolower($month), $this->months)) {
				return $this->months[strtolower($month)];
			}
		}
		return 12;
	}

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

	
	
	private function generateLinks($prefix) {
		$links = [];
		
		for($year = 2015; $year <= 2017; $year++) {
			$links[$year] = [$prefix ,[]];
			for($month = 1; $month <= 12; $month++) {
				$monthName = date('F', mktime(0, 0, 0, $month, 1, 2000, 0));
				$links[$year][1][] = [
					'href' => "/$prefix/$year/" . strtolower($monthName) . '/',
					'title' => ucfirst($prefix) . " $monthName $year",
					'text' => $monthName,
				];		
			}
		}
		return $links;
	}
	
    public function actionIndex()
	{
		$searchModel = new ArtistSearch();
		$dataProvider = $searchModel->searchActive();

		return $this->render('index', [
			'headerLinks' => $this->generateLinks('world'),
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
    }
	
	/**
	 * Route:
	 * '<route:\w+>' => 'site/artist',
	 */
    public function actionArtist()
	{
		$get = Yii::$app->request->queryParams;
		if (isset($get['route'])) {
			$route = strtolower($get['route']);
			switch ($route) {
				case 'asia':
				case 'africa':
				case 'australia':
				case 'europe':
				case 'southamerica':
				case 'northamerica':
					return $this->actionArtistContinent(ucfirst($route));
				case 'world':
					return $this->actionArtistCelebritiesWorld();
			}
		}
		return $this->actionArtistplansWorldYear();
	}
	
	public function actionArtistContinent($continent) {
		
		$searchModel = new ArtistSearch();
		$dataProvider = $searchModel->searchActiveContinent($continent);

		return $this->render('artist', [
			'headerLinks' => $this->generateLinks(strtolower($continent)),
			'continent' => $searchModel->getContinentName($continent),
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
    }
	
	
	public function actionArtistCelebritiesWorld() {
		
		$searchModel = new ArtistSearch();
		$dataProvider = $searchModel->searchActiveCelebrities();

		return $this->render('artist', [
			'headerLinks' => $this->generateLinks('world'),
			'continent' => 'World',
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
	
	public function actionSay($message = 'Hello')
	{
		return $this->render('say', ['message' => $message]);
	}
		
	/**
	 * Routes:
	 * '<route:\w+>/<year:\d+>/<month:\d+>' => 'site/artistplans',
	 * '<route:\w+>/<year:\d+>/<month:\w+>' => 'site/artistplans'
	 */
	public function actionArtistplans() {
		$get = Yii::$app->request->queryParams;
		if (isset($get['route'])) {
			switch ($get['route']) {
				case 'asia':
				case 'africa':
				case 'australia':
				case 'europe':
				case 'southamerica':
				case 'northamerica':
					return $this->actionArtistplansContinentMonth(ucfirst($get['route']));
				case 'world':
					return $this->actionArtistplansWorldMonth();
			}
		}
		else {
			return $this->actionArtistplansWorldYear();
		}
	}
	
	/**
	 * Route:
	 * '<route:\w+>/<year:\d+>' => 'site/artistplansforyear',
	 */
	public function actionArtistplansforyear() {
	$get = Yii::$app->request->queryParams;
		if (isset($get['route'])) {
			switch ($get['route']) {
				case 'asia':
				case 'africa':
				case 'australia':
				case 'europe':
				case 'southamerica':
				case 'northamerica':
					return $this->actionArtistplansContinentYear(ucfirst($get['route']));
				case 'world':
					return $this->actionArtistplansWorldYear();
			}
		}
		else {
			return $this->actionArtistplansWorldYear();
		}
	}
	
	public function actionArtistplansWorldYear() {
		$get = Yii::$app->request->queryParams;
		$year = isset($get['year']) ? intval($get['year']) : 2015;
		
		$searchModel = new ArtistPlanSearch();
		$dataProvider = $searchModel->searchActiveCelebritiesWorldYear($year);

        return $this->render('worldyear', [
			'headerLinks' => $this->generateLinks('world'),
            'year' => $year,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);	
	}
	
	public function actionArtistplansWorldMonth()
    {
		$get = Yii::$app->request->queryParams;
		$year = isset($get['year']) ? intval($get['year']) : 2015;
		if (isset($get['month'])) {
			$month = $this->parseMonth($get['month']);
			$searchModel = new ArtistPlanSearch();
			$dataProvider = $searchModel->searchActiveCelebritiesWorldMonth($year, $month);

			return $this->render('world', [
				'headerLinks' => $this->generateLinks('world'),
				'year' => $year,
				'month' => date('F', mktime(0, 0, 0, $month, 1, 2000, 0)),
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider
			]);
		}
		else {
			return $this->actionArtistplansWorldyear();
		}
    }
	
	private function actionArtistplansContinentMonth($continent)
    {
		$get = Yii::$app->request->queryParams;
		$year = isset($get['year']) ? intval($get['year']) : 2015;
		$month = isset($get['month']) ? $this->parseMonth($get['month']) : 1;
		
		$searchModel = new ArtistPlanSearch();
		$dataProvider = $searchModel->searchActiveContinentMonth($continent, $year, $month);

        return $this->render('continent', [
			'headerLinks' => $this->generateLinks(strtolower($continent)),
			'continent' => $searchModel->getContinentName($continent),
            'year' => $year,
			'month' => date('F', mktime(0, 0, 0, $month, 1, 2000, 0)),
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
	
	private function actionArtistplansContinentYear($continent)
    {
		$get = Yii::$app->request->queryParams;
		$year = isset($get['year']) ? intval($get['year']) : 2015;
		
		$searchModel = new ArtistPlanSearch();
		$dataProvider = $searchModel->searchActiveContinentYear($continent, $year);

        return $this->render('continentyear', [
			'headerLinks' => $this->generateLinks(strtolower($continent)),
			'continent' => $searchModel->getContinentName($continent),
            'year' => $year,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}
