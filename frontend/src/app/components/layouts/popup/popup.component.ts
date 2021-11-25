import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { CustomValidator } from './../../../shared/validator/validator';
import { Router, ActivatedRoute } from '@angular/router';
import { HttpService } from './../../../services/http.service';
import { environment } from './../../../../environments/environment';
import { ToastrService } from 'ngx-toastr';
import { ViewChild, ElementRef } from '@angular/core';

@Component({
  selector: 'app-popup',
  templateUrl: './popup.component.html',
  styleUrls: ['./popup.component.css']
})
export class PopupComponent implements OnInit {
  demoForm: FormGroup;
  signUpForm: FormGroup;
  public submitted = false;

  @ViewChild('demoFormCloseBtn') demoFormCloseBtn: ElementRef;

  constructor(
    @Inject(Router) private router,
    @Inject(HttpService) private http,
    @Inject(ActivatedRoute) private route,
    private formBuilder: FormBuilder,
    private toastr: ToastrService
  ) { }

  ngOnInit(): void {
    this.demoForm = this.formBuilder.group({
      type: ['D', Validators.required],
      name: ['', Validators.required],
      email: ['', [Validators.required,CustomValidator.email]]
    });
  }

  // Demo form submit
  get demoFormVal() {
    return this.demoForm.controls;
  }
  submitDemoForm() {
    this.submitted = true;
    if (this.demoForm.invalid) {
      return;
    } else {
      // console.log(this.demoForm.value);
      this.http.setModule('capture_registration').create(this.demoForm.value).subscribe((response) => {
        if (response.capture_details.status == 200) {
          this.toastr.success('Thank you for registering with us, we will get back to you shortly.', 'Success!');
          this.demoForm.reset();
          this.submitted = false;
          // Close modal
          this.closeDemoModal();
        } else {
          this.toastr.error('Oops! Something went wrong, please try again later.', 'Error!');
          this.submitted = false;
        }
      }, (error) => {
        this.toastr.error(error.error.message, 'Error!');
        this.submitted = false;
      });
    }
  }
  // Close modal function
  private closeDemoModal(): void {
    this.demoFormCloseBtn.nativeElement.click();
  }  

}
