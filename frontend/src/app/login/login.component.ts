import { Component, OnInit } from '@angular/core';
import {Router, RouterModule, ActivatedRoute, Params} from "@angular/router";
import {User} from "../models/user";
import {UserService} from "../services/user.service";

@Component({
  selector: 'login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
    providers:[
        UserService
    ]
})
export class LoginComponent implements OnInit {

  public title;
  public user: User;
  public token;
  public identity;


  constructor(public _userService: UserService, public _route: RouterModule
  ) {
      this.title = 'Identifique-se'
      this.user =  new User(1,'ROLE_USER','','','','',true);
  }

  ngOnInit() {

    let user =  this._userService.getIdentity();
    console.log(user.name)
  }

    onSubmit(form){
      console.log(this.user);
        this._userService.signup(this.user).subscribe(
            response => {
                this.token = response;
                localStorage.setItem('token',this.token);
                this._userService.signup(this.user, true).subscribe(
                    response => {
                       this.identity = response;
                        localStorage.setItem('identity', JSON.stringify(this.identity));
                    },
                    error => {
                        console.log(<any>error)
                    }
                );


            },
            error => {
              console.log(<any>error)
            }
        )
    }

    logout(){
      this._route.params.subscribe(params => {
          let logout = +params['sure'];
         if(logout == 1){
            localStorage.removeItem('identity');
            localStorage.removeItem('token');

            this.identity = null;
            this.token = null;
         }
      });
    }

}
