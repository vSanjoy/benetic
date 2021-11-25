import { AbstractControl, ValidationErrors } from '@angular/forms';
import { HttpClient } from '@angular/common/http';

export class CustomValidator {
	
	constructor(
		protected http: HttpClient,
	) { }

	static email(control: AbstractControl): ValidationErrors | null {
		if (control && control.value !== null && control.value !== undefined) {
			let Regex = new RegExp('^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$');

			if (!Regex.test(control.value)) {
				return { email: true }
			}

			if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(control.value)) {
				return { email: true }
			}
		}
		return null; 
	}

	static password (control: AbstractControl): ValidationErrors | null {
		if (control && control.value !== null && control.value !== undefined) {
			if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/.test(control.value)) {
				// console.log('not match');
				return { password: true }
			}
		}
		return null;
	}

	static MatchPassword(AC: AbstractControl) {
		let new_password = AC.get('new_password').value; // to get value in input tag
		let retype_password = AC.get('retype_password').value; // to get value in input tag
		if (new_password != retype_password) {
			// console.log('false');
			AC.get('retype_password').setErrors({ MatchPassword: true })
		} else {
			// console.log('true');
			return null;
		}
	}

	static positiveNumberValidator(control: AbstractControl): ValidationErrors | null {
		if (control && control.value !== null && control.value !== undefined) {
			let Regex = new RegExp('^[1-9]+$');

			if (!Regex.test(control.value)) {
				return { positiveNumber: true }
			}
		}
		return null;
	}	
	
}

