import { Component, OnInit } from '@angular/core';

declare const responsiveMenu:any;

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
})
export class HeaderComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {

   responsiveMenu(); 
  
  }

}
