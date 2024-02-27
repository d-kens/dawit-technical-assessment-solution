import { Routes } from '@angular/router';
import { LoginComponent } from './components/login/login.component';
import { LayoutComponent } from './components/layout/layout.component';
import { ClientsComponent } from './components/clients/clients.component';

export const routes: Routes = [
    {
      path: '', redirectTo: 'login', pathMatch: 'full'
    },
    {
      path: 'login',
      component: LoginComponent
    },
    {
      path: '',
      component: LayoutComponent,
      children: [
        {
          path: 'clients',
          component: ClientsComponent
        }
      ]
    }
];
