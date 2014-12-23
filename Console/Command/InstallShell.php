<?php

class InstallShell extends AppShell {
    public function main() {
        $this->out(__('Bienvenue dans l\'installation du plugin Media.'));

		$this->dispatchShell('schema create DbMedia --plugin Media');

    }
}