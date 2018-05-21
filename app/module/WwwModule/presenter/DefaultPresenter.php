<?php

namespace App\WwwModule\Presenter;

final class DefaultPresenter extends \Nepttune\Presenter\BasePresenter implements \Nepttune\TI\ISitemap
{
    use \Nepttune\TI\TSitemap;

    /**
     * @sitemap
     */
    public function actionDefault() {}
}
