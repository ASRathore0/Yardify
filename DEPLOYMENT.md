# Automatic Deployment to Hostinger with GitHub Actions

This guide explains how to set up automatic deployment for your Laravel application from GitHub to Hostinger using GitHub Actions.

## Prerequisites

1.  **GitHub Repository**: Your project must be pushed to a GitHub repository.
2.  **Hostinger Plan**: You need a Hostinger plan that supports SSH access (most shared hosting plans do).
3.  **SSH Access**: Ensure SSH access is enabled in your Hostinger hPanel.

## Step 1: Generate SSH Keys

You need an SSH key pair to allow GitHub Actions to securely connect to your Hostinger server.

1.  Open your local terminal (e.g., Git Bash, Terminal).
2.  Run the following command to generate a new SSH key pair (press Enter for default file location, and leave passphrase empty):
    ```bash
    ssh-keygen -t ed25519 -C "github-actions-deploy"
    ```
3.  This will create two files:
    -   `id_ed25519` (Private Key) - **Keep this secret!**
    -   `id_ed25519.pub` (Public Key)

## Step 2: Add Public Key to Hostinger

1.  Log in to your Hostinger hPanel.
2.  Go to **Advanced** > **SSH Access**.
3.  Enable SSH Access if it's not already enabled.
4.  Scroll down to **Authorized Keys**.
5.  Open the `id_ed25519.pub` file you generated on your computer and copy its contents.
6.  Paste the contents into the **Authorized Keys** field in hPanel and click **Add key**.

## Step 3: Add Secrets to GitHub Repository

1.  Go to your GitHub repository.
2.  Navigate to **Settings** > **Secrets and variables** > **Actions**.
3.  Click **New repository secret**.
4.  Add the following secrets:

    -   **`HOSTINGER_HOST`**: Your Hostinger IP address (found in hPanel under **SSH Access**).
    -   **`HOSTINGER_USERNAME`**: Your SSH username (found in hPanel under **SSH Access**, e.g., `u123456789`).
    -   **`HOSTINGER_SSH_PRIVATE_KEY`**: Paste the entire content of your `id_ed25519` private key file.
    -   **`HOSTINGER_PORT`**: `65002` (This is the standard Hostinger SSH port).
    -   **`DEPLOY_PATH`**: The full path to your project on the server (e.g., `/home/u123456789/domains/indigo-manatee-379344.hostingersite.com/public_html`). You can find this by running `pwd` in the Hostinger Terminal.

## Step 4: Configure GitHub Actions Workflow

I have already created a workflow file for you at `.github/workflows/deploy.yml`.

Verify the content matches your needs. This workflow will:
1.  Trigger on every push to the `master` branch.
2.  SSH into your Hostinger server.
3.  Navigate to your deployment path.
4.  Pull the latest changes from GitHub.
5.  Install PHP dependencies (`composer install`).
6.  Run database migrations (`php artisan migrate`).
7.  Optimize the application (`php artisan optimize`).

**Important Note on Assets (CSS/JS):**
Since `/public/build` is ignored in `.gitignore`, your frontend assets won't be updated automatically. You have two options:
1.  **Recommended for CI/CD**: Update the workflow to build assets on GitHub Actions and upload them to the server (more complex involves `scp`).
2.  **Simpler**: Remove `/public/build` from your `.gitignore` file and commit the built assets manually before pushing.

## Step 5: Initial Server Setup (One-time)

Before the first automatic deployment, you must manually clone the repository on the server.

1.  Ssh into your server:
    ```bash
    ssh -p 65002 u123456789@your-server-ip
    ```
2.  Navigate to your domain's public folder (usually `domains/your-domain.com/public_html`).
    ```bash
    cd domains/indigo-manatee-379344.hostingersite.com/public_html
    ```
    *(If the directory is not empty, you might need to move existing files or delete them, but be careful with `.env`)*.
3.  Initialize git (if not already done via Hostinger Git tool):
    ```bash
    git init
    git remote add origin https://github.com/your-username/your-repo.git
    git fetch
    git checkout master
    ```
4.  Ensure your `.env` file is present and configured on the server.

Once this is set up, every push to `master` will trigger the deployment action!
