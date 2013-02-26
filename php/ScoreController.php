<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Entity\Messages as Messages;
use Admin\Entity\WebCourses as WebCourse;
use Admin\Entity\SmsCourses as SmsCourse;
use Admin\Model\User;
use Doctrine\Common\Util\Debug as D;
use Admin\Entity\CourseCompanies as CourseCompanies;



class ScoreController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {

        $name = $this->params()->fromRoute('name');
        $course_id = $this->params()->fromRoute('course_id');
        $score_setting = $this->getEntityManager()->getRepository('\Admin\Entity\ScoreSettings')->findOneBy(array('name' => $name, 'course_id' => $course_id));

        if ($score_setting->type == 'web') {
            $course = $this->getEntityManager()->getRepository('\Admin\Entity\WebCourses')->findOneBy(array('id' => $score_setting->course_id));
        } else {
            $course = $this->getEntityManager()->getRepository('\Admin\Entity\SmsCourses')->findOneBy(array('id' => $score_setting->course_id));

        }
        $course_campaigns =  $this->getEntityManager()->getRepository('\Admin\Entity\CourseCompanies')->findBy(array(
            'course_id' => $score_setting->course_id,
            'type_course' => $score_setting->type
        ));

        $campaigns_id = array();
        foreach ($course_campaigns as $course_campaign) {
            $campaigns_id[] = $course_campaign->companies_id;
        }
        $campaigns_id_str = implode(', ', $campaigns_id);
        $users = $course->getUsers();
        $scores = array();
        foreach ($users as $user) {
            $score = $this->getEntityManager()->createQuery(
                "SELECT SUM(result.points) FROM Admin\\Entity\\WebResult result WHERE result.user_id = {$user->id} AND result.campaign_id IN ({$campaigns_id_str})")
                ->getSingleResult();
            if ($score[1] != null) {
                $scores[$user->id] = $score[1];
                $users_arr[$user->id] = $user;
            }
        }
        arsort($scores);
        $rank = 1;
        $scores_view = array();
        foreach ($scores as $key => $score) {
            if ($rank <= $score_setting->top_n) {
                $scores_view[$key] = array('score' => $score, 'rank' => $rank++);
            } else {
                break;
            }
        }

        $view = new ViewModel(/*array(
            'scores' => $scores_view,
            'users' => $users_arr
        )*/);

        $this->layout('templates/default');
        $view->setVariable('scores', $scores_view);
        $view->setVariable('users', $users_arr);
        $view->setTemplate('index/score');
        return $view;
    }


    public function getEntityManager() {
        if (null == $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
    private function checkAuth() {
        session_start();
        return isset($_SESSION['auth']);
    }
}