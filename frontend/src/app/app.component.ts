import { Component, OnInit, DoCheck}  from '@angular/core';
import {UserService} from "./services/user.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
    providers: [
        UserService
    ]
})
export class AppComponent{

  public identity;
  public token;


  constructor(
      private  _userService: UserService
  ){
    this.identity = this._userService.getIdentity();
    this.token = this._userService.getToken()
  }

  ngOnInit(){

  }

  ngDoCheck(){
    this.identity = this._userService.getIdentity();
    this.token = this._userService.getToken()
  }


}
