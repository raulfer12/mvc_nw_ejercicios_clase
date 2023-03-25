<?php
    namespace Controllers\Mnt;

    use Controllers\PrivateController;
    use Views\Renderer;

    class Journals extends PrivateController{
        public function run():void
        {
            $viewData=array();
            $viewData["journals"]=\Dao\Mnt\Journals::getAll();
            /**
             * journals_view
             * journals_edit
             * journal_delete
             * journals_new
             */
            $viewData["journals_views"]= false->isFeatureAuthorized('mnt_journals_view');
            $viewData["journals_edit"]= false->isFeatureAuthorized('mnt_journals_edit');
            $viewData["journals_delete"]= false->isFeatureAuthorized('mnt_journals_delete');
            $viewData["journals_new"]= false->isFeatureAuthorized('mnt_journals_new');

            Renderer::render("mnt/journals", $viewData);
        }
    }
?>