<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  public function boot(): void
  {
    View::composer('*', function ($view) {

      $verticalMenuData = json_decode(
        file_get_contents(base_path('resources/menu/verticalMenu.json'))
      );

      $horizontalMenuData = json_decode(
        file_get_contents(base_path('resources/menu/horizontalMenu.json'))
      );

      $role = auth()->check() ? auth()->user()->role : null;

      if ($role && isset($verticalMenuData->menu)) {
        $verticalMenuData->menu = collect($verticalMenuData->menu)
          ->filter(function ($menu) use ($role) {

            // role parent wajib cocok
            if (isset($menu->roles) && !in_array($role, $menu->roles)) {
              return false;
            }

            if (isset($menu->submenu)) {
              $menu->submenu = collect($menu->submenu)
                ->filter(fn ($sub) =>
                  isset($sub->roles) && in_array($role, $sub->roles)
                )
                ->values();
            }

            return true;
          })
          ->values();
      }

      $view->with('menuData', [$verticalMenuData, $horizontalMenuData]);
    });
  }
}
