<?php

namespace App\WwwModule\Presenter;

final class GalleryPresenter extends \Nepttune\Presenter\BasePresenter implements \Nepttune\TI\ISitemap
{
    use \Nepttune\TI\TSitemap;

    /**
     * @sitemap
     */
    public function actionDefault() : void
    {
        $this->template->images = [];
    }
}
