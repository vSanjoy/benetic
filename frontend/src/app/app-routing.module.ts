import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AdvisorsComponent } from './components/advisors/advisors.component';
import { AssetManagersComponent } from './components/asset-managers/asset-managers.component';
import { HomeComponent } from './components/home/home.component';
import { LayoutComponent } from './components/layouts/layout/layout.component';
import { PlatformComponent } from './components/platform/platform.component';
import { RecordkeepersComponent } from './components/recordkeepers/recordkeepers.component';
import { AboutComponent } from './components/about/about.component';

const routes: Routes = [
	{
    path: '', component: LayoutComponent,
    children: [
      {
        path: '', component: HomeComponent
      },
      {
        path: 'platform', component: PlatformComponent
      },
      {
        path: 'advisors', component: AdvisorsComponent
      },
      {
        path: 'recordkeepers', component: RecordkeepersComponent
      },
      {
        path: 'asset-managers', component: AssetManagersComponent
      }, 
      {
        path: 'about-us', component: AboutComponent
      }  

    ]
  },
  // otherwise redirect to home
  { 
    path: '**',
    redirectTo: ''
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {
    scrollPositionRestoration: 'enabled'
  })],
  exports: [RouterModule]
})
export class AppRoutingModule { }
