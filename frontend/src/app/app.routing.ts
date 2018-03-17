import {ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule} from "@angular/router";

//Components
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { DefaultComponent } from './default/default.component';


const appRoutes: Routes = [
    {path:'', component: DefaultComponent},
    {path:'home', component: DefaultComponent},
    {path:'login', component: LoginComponent},
    { path: 'logout/:sure', component: LoginComponent},
    {path:'registro', component: RegisterComponent},
    {path:'**', component: DefaultComponent}
];

export const appRoutingProviders: any[] = [];
export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);