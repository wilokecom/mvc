<?php declare(strict_types=1);
namespace MVC\Controllers;

/**
 * Class TagController
 * @package MVC\Controllers
 */
class TagController extends TaxonomyController
{
    /**
     * @param $sTaxonomy
     */
    public function index($sTaxonomy)
    {
        parent::index("tag");
    }
    /**
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function add($sTaxonomy)
    {
        parent::add("tag");
    }
    /**
     * Display dashboard of Taxonomy
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function dashboard($sTaxonomy)
    {
        parent::dashboard("tag");
    }
    /**
     * Handle Add:after get data from ajax from page add/post
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function handleQuickAdd($sTaxonomy)
    {
        parent::handleQuickAdd("tag");
    }
    /**
     * Handle Add:Afer press Add Category/Tag...
     * @param $sTaxonomy
     */
    public function handleAdd($sTaxonomy)
    {
        parent::handleAdd("tag");
    }
    /**
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function edit($sTaxonomy)
    {
        parent::edit("tag");
    }
    /**
     * @param $sTaxonomy
     */
    public function handleEdit($sTaxonomy)
    {
        parent::handleEdit("tag");
    }
    /**
     * Delete info taxonomy
     */
    public function delete()
    {
        parent::delete();
    }
}
