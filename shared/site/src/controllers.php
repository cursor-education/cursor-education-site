<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use app\models\Course as CourseModel;
use app\models\Partner as PartnersModel;

// @service for Courses model
$app['courses.model'] = $app->share(function () use ($app) {
    return new CourseModel($app);
});

// @service for Partners model
$app['partners.model'] = $app->share(function () use ($app) {
    return new PartnersModel($app);
});

// @route landing page
$app->match('/', function () use ($app) {
    $params = array(
        'courses' => $app['courses.model']->getAll(),
        'partners' => $app['partners.model']->getAll(),
    );

    return $app['twig']->render('landing/index.html.twig', $params);
})
->bind('landing');

// @route course page
$app->match('/course/{id}', function (Request $request) use ($app) {
    $courseId = $request->get('id');
    $course = $app['courses.model']->findBy('id', $courseId);

    if (!$course) {
        $normalizedCourseId = str_replace('-', ' ', $courseId);
        $errorMessage = sprintf('requested course with name "%s" has been not found', $normalizedCourseId);

        $app->abort(404, $errorMessage);
    }

    return $app['twig']->render('course/index.html.twig', array(
        'course' => $course,
    ));
})
->bind('course');

// @route teacher profile page
$app->match('/teacher/{id}', function (Request $request) use ($app) {
    $lectureId = $request->get('id');

    return $app['twig']->render('teacher/index.html.twig', array(
        'teacher' => array(
            'id' => $lectureId,
            'name' => 'Max XZ'
        ),
    ));
})
->bind('teacher');

// @route submit form from landing page
$app->post('/callme', function (Request $request) use ($app) {
    $filename = ROOT_DIR.'/web/'.$app['form.file'];

    $data = array(
        $request->get('name'),
        $request->get('phone'),
    );

    $f = fopen($filename, 'aw');
    fwrite($f, join("\t", $data)."\n");
    fclose($f);

    sleep(2);

    return 'ok';
})
->bind('landing-form');

// @route submit form from course page
$app->post('/callme-course', function (Request $request) use ($app) {
    $filename = ROOT_DIR.'/web/'.$app['form.file'];

    $data = array(
        $request->get('course'),
        $request->get('name'),
        $request->get('phone'),
    );

    $f = fopen($filename, 'aw');
    fwrite($f, join("\t", $data)."\n");
    fclose($f);

    sleep(2);

    return 'ok';
})
->bind('course-form');

// @route update db changes
$app->match('/admin/update', function () use ($app) {
    echo time().'<br>';

    $courses = $app['courses.model']->update();
    echo sprintf('%s = %d<br>', 'courses', count($courses));

    $partners = $app['partners.model']->update();
    echo sprintf('%s = %d<br>', 'partners', count($partners));

    return '';
});

//
$app->error(function (\Exception $e, $code) use ($app) {
    // if ($app['debug']) {
    //     return;
    // }

    return $app['twig']->render('error/index.html.twig', array(
        'code' => $code,
        'message' => $e->getMessage(),
    ));
});

return $app;