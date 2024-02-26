import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, FormsModule, ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, ReactiveFormsModule, HttpClientModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  form: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private http: HttpClient,
    private router: Router
  ){
    this.form = this.formBuilder.group({
      email: '',
      password: ''
    })
  }

  onSubmit(): void {
    this.http.post('http://127.0.0.1:8000/api/v1/login', this.form.getRawValue(), {withCredentials: true})
      .subscribe(res => {
        this.router.navigate(['/'])
      });
  }


}
