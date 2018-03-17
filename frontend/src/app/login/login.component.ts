import { Component, OnInit } from '@angular/core';
import { Router, RouterModule, ActivatedRoute, Params } from "@angular/router";
import { User } from "../models/user";
import { UserService } from "../services/user.service";

@Component({
    selector: 'login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css'],
    providers: [
        UserService
    ]
})
export class LoginComponent implements OnInit {

    public title;
    public user: User;
    public token;
    public identity;
    public status;

    constructor(
        private _route: ActivatedRoute,
        private _router: Router,
        public _userService: UserService,
       
    ) {
        this.title = 'Identifique-se'
        this.user = new User(1, 'ROLE_USER', '', '', '', '', true);
    }

    ngOnInit() {

        let user = this._userService.getIdentity();
        this.logout()
    }

    onSubmit(form) {
        console.log(this.user);
        this._userService.signup(this.user).subscribe(
            response => {

                if(response.status != 'error'){
                    this.status = 'success'
                    this.token = response;
                    localStorage.setItem('token', this.token);
                    this._userService.signup(this.user, true).subscribe(
                        response => {
                            this.identity = response;
                            localStorage.setItem('identity', JSON.stringify(this.identity));
                            this._router.navigate(['home'])
                               
                    },
                    error => {
                        console.log(<any>error)
                    }
                );
            }else{
                this.status = 'error';
            }

            },
            error => {
                console.log(<any>error)
            }
        )
    }

    logout() {
        console.log('chegou')
        this._route.params.subscribe(params => {
            console.log('chegou')

            let logout = +params['sure'];

            if (logout == 1) {
                console.log('chegou')
                localStorage.removeItem('identity');
                localStorage.removeItem('token');
                this.identity = null;
                this.token = null;
                //Redirect
                this._router.navigate(['home'])
            }

        })
    }


}
