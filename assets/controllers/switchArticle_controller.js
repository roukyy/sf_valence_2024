import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.querySelector('input[type="checkbox"]')
            .addEventListener('change', async (e) => {
                const id = e.currentTarget.dataset.articleId;

                const response = await fetch(`/admin/articles/${id}/switch`);

                if (response.ok) {
                    const data = await response.json();
                    const label = this.element.querySelector('label');

                    label.textContent = data.enable ? 'Actif' : 'Inactif';

                    if (data.enable) {
                        label.classList.replace('text-danger', 'text-success');
                    } else {
                        label.classList.replace('text-success', 'text-danger');
                    }
                } else {
                    if (!document.querySelector('.alert.alert-danger')) {
                        const alert = document.createElement('div');
                        alert.classList.add('alert', 'alert-danger');
                        alert.textContent = "Une erreur est survenue, veuillez réessayer plus tard.";

                        document.querySelector('main').prepend(alert);

                        window.scrollTo(0, 0);

                        setTimeout(() => {
                            alert.remove()
                        }, 3000);
                    }
                }
            });
    }
}
