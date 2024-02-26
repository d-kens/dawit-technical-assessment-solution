import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, FormsModule, ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [FormsModule, ReactiveFormsModule, HttpClientModule],
  templateUrl: './register.component.html',
  styleUrl: './register.component.css'
})
export class RegisterComponent {

  form: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private http: HttpClient,
    private router: Router
    ) {
    this.form = this.formBuilder.group({
      name: '',
      email: '',
      password: ''
    })
  }


  onSubmit(): void {
    console.log(this.form.getRawValue());
    console.log('This is the serve response');
    this.http.post('http://127.0.0.1:8000/api/v1/register', this.form.getRawValue())
      .subscribe(res => {
        this.router.navigate(['/login'])
      });
  }

}
