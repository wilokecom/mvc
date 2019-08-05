<?php declare(strict_types=1);
namespace MVC\Controllers;

/**
 * Class CategoryController
 * @package MVC\Controllers
 */
class CategoryController extends TaxonomyController
{
    /**
     * @param $sTaxonomy
     */
    public function index($sTaxonomy)
    {
        parent::index("category");
    }
    /**
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function add($sTaxonomy)
    {
        parent::add("category");
    }
    /**
     * Display dashboard of Taxonomy
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function dashboard($sTaxonomy)
    {
        parent::dashboard("category");
    }
    /**
     * Handle Add:after get data from ajax from page add/post
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function handleQuickAdd($sTaxonomy)
    {
        parent::handleQuickAdd("category");
    }
    /**
     * Handle Add:Afer press Add Category/Tag...
     * @param $sTaxonomy
     */
    public function handleAdd($sTaxonomy)
    {
        parent::handleAdd("category");
    }
    /**
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function edit($sTaxonomy)
    {
        parent::edit("category");
    }
    /**
     * @param $sTaxonomy
     */
    public function handleEdit($sTaxonomy)
    {
        parent::handleEdit("category");
    }
    /**
     * Delete info taxonomy
     */
    public function delete()
    {
        parent::delete();
    }
}
