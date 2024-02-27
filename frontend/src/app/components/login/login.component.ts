import { HttpClient, HttpErrorResponse  } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, HttpClientModule, RouterLink],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {

  loginObj: Login;

  constructor(private http: HttpClient,private router: Router) {
    this.loginObj = new Login();
  }

  onLogin() {
    console.log(this.loginObj);

    this.http.post('http://127.0.0.1:8000/api/v1/login', this.loginObj)
      .subscribe(
        (res: any) => {
          console.log(res.user);
          console.log(res.token);

          if (res.user) {
            alert('Login successful');
            localStorage.setItem('auth-token', res.token);
            this.router.navigateByUrl('/clients');
          }
        },
        (error: HttpErrorResponse) => {
          if (error.status === 401) {
            alert('Unauthorized: Please check your credentials');
          } else {
            console.error('Error occurred:', error);
          }
        }
      );
  }
}



export class Login {
    email: string;
    password: string;
    constructor() {
      this.email = '';
      this.password = '';
    }
}
