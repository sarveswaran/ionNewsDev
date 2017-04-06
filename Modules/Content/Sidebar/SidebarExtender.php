<?php

namespace Modules\Content\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\User\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('content::contents.title.contents'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('Story'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.content.content.create');
                    $item->route('admin.content.content.index');
                    $item->authorize(
                        $this->auth->hasAccess('content.contents.index')
                    );
                });
                $item->item(trans('content::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.content.category.create');
                    $item->route('admin.content.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('content.categories.index')
                    );
                });
                $item->item(trans('content::contentimages.title.contentimages'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.content.contentimages.create');
                    $item->route('admin.content.contentimages.index');
                    $item->authorize(
                        $this->auth->hasAccess('content.contentimages.index')
                    );
                });
                $item->item(trans('content::contentusers.title.contentusers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.content.contentuser.create');
                    $item->route('admin.content.contentuser.index');
                    $item->authorize(
                        $this->auth->hasAccess('content.contentusers.index')
                    );
                });
                $item->item(trans('content::contentcompanies.title.contentcompanies'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.content.contentcompany.create');
                    $item->route('admin.content.contentcompany.index');
                    $item->authorize(
                        $this->auth->hasAccess('content.contentcompanies.index')
                    );
                });
// append





            });
        });

        return $menu;
    }
}
