import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [FormsModule, HttpClientModule, RouterLink],
  templateUrl: './register.component.html',
  styleUrl: './register.component.css'
})
export class RegisterComponent {

  registerObj: Register;

  constructor (private http: HttpClient, private router: Router) {
    this.registerObj = new Register();
  }


  onRegister() {
    console.log(this.registerObj);

    this.http.post('http://127.0.0.1:8000/api/v1/register', this.registerObj)
    .subscribe(
      (res:any) => {
        if (res.user) {
          alert('Registration Sucessfull');
          this.router.navigateByUrl('/login')
        }
      },
      (error) => {
        if (error.status === 422) {
          alert('Validation Error: ' + error.error.message);
        } else {
          console.error('An error occurred:', error);
        }
      }
    )
  }




}

export class Register {
  name: string;
  email: string;
  password: string;
  constructor() {
    this.name = ''
    this.email = '';
    this.password = '';
  }
}
