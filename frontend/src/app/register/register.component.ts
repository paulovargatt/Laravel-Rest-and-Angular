import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute, Params} from "@angular/router";
import {User} from "../models/user";
import {UserService} from "../services/user.service";

@Component({
    selector: 'register',
    templateUrl: './register.component.html',
    styleUrls: ['./register.component.css'],
    providers: [
        UserService
    ]
})
export class RegisterComponent implements OnInit {

    public title: string;
    public user: User;
    public status;

    constructor(private userService: UserService,
                private router: Router,
                private route: ActivatedRoute
    )
    {
        this.title = "Faça seu registro";
        this.user = new User(1,'ROLE_USER','','','','',false);
    }

    ngOnInit() {

    }

    onSubmit(form){
        this.userService.register(this.user).subscribe(
            response => {
               if(response.status == 'success'){
                   console.log(response);
                   this.status = response.status;
                   this.user =  new User(1,'ROLE_USER','','','','',false);
                   form.reset()
               }else{
                   console.log(response);
                   this.status = 'error';
               }
            },
            error => {
                console.log(<any>error);
            }
        )
    }

}
