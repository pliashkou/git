<?php

class Page_ArticleController extends Zend_Controller_Action
{

    public function init()
    {
        $seller = $this->getRequest()->getParam('seller');
        if ($seller != '') {
            $this->_redirect('/site/page/view');
        }
    }

    public function indexAction()
    {
        $filters = array(
            'page' => array('HtmlEntities','StripTags','StringTrim'),
        );
        $validators = array(
            'page' => array ('NotEmpty','Int'),
        );

        $input = new Zend_Filter_Input($filters,$validators);
        $input->setData($this->getRequest()->getParams());
        if($input->isValid()) {
            $q = Doctrine_Query::create()
                ->from('Adz_Model_Articles a')
                ->where('a.ArticleId = ?', $input->page);
            $result = $q->fetchArray();
            $this->view->article = $result[0];
        }
    }


}

