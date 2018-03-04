import { Component, OnInit } from '@angular/core';
import {Router, ActivatedRoute, Params} from "@angular/router";

@Component({
  selector: 'login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  public title;

  constructor(

  ) {
      this.title = 'Identifique-se'
  }

  ngOnInit() {
    console.log('Login carregado')
  }

}
