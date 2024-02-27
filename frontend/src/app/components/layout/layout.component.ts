import { Component } from '@angular/core';
import { Router, RouterOutlet } from '@angular/router';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-layout',
  standalone: true,
  imports: [RouterOutlet],
  templateUrl: './layout.component.html',
  styleUrl: './layout.component.css'
})
export class LayoutComponent {

  constructor(private router: Router, private http: HttpClient) {

  }

  logout() {
    this.http.post('http://127.0.0.1:8000/api/v1/logout', {}).subscribe(
      response => {
        alert('Logged out successfully');
        this.router.navigateByUrl('/login');
      },
      error => {
        console.error('Logout failed:', error);

        alert('Logout failed. Please try again.');
      }
    )
  }
}
