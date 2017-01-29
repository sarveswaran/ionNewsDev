<?php

namespace Modules\Questions\Sidebar;

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
            $group->item(trans('questions::questions.title.questions'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('questions::questions.title.questions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.questions.questions.create');
                    $item->route('admin.questions.questions.index');
                    $item->authorize(
                        $this->auth->hasAccess('questions.questions.index')
                    );
                });
                $item->item(trans('questions::likes.title.likes'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.questions.likes.create');
                    $item->route('admin.questions.likes.index');
                    $item->authorize(
                        $this->auth->hasAccess('questions.likes.index')
                    );
                });
                $item->item(trans('questions::comments.title.comments'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.questions.comments.create');
                    $item->route('admin.questions.comments.index');
                    $item->authorize(
                        $this->auth->hasAccess('questions.comments.index')
                    );
                });
                $item->item(trans('questions::votes.title.votes'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.questions.vote.create');
                    $item->route('admin.questions.vote.index');
                    $item->authorize(
                        $this->auth->hasAccess('questions.votes.index')
                    );
                });
                $item->item(trans('questions::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.questions.category.create');
                    $item->route('admin.questions.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('questions.categories.index')
                    );
                });
// append





            });
        });

        return $menu;
    }
}
