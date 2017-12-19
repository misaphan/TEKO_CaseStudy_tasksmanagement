# Tasks Management

## Description
- A task management software, in short, is something like Google Keep.

The system with different users that can be created, updated, searched. The users should not be deleted, since we might need to keep track of their activities history within the system in the future. 
Administrators are ones who create, update users in the system, and choose to set admin permission for them or not.</br></br>
Each user can organize many cards, which is basically a to-do list. The card has a title saying what it is about, and has its own background color – which can be set right when a user is interacting with it.</br></br>
One card can have many tasks inside. For each task, we have one short description and two states: either completed, or not. User can add new tasks, remove tasks, or even remove the cards themselves.</br></br> 
Once a card is removed, all the tasks inside are also removed. The removed card contains all of its tasks, and stays in the trash of the owner. Items in the trash will be removed automatically after 1 day, or when the owner chooses to “Empty trash” </br></br>
Each card has two sections: one for not completed (the top section) and one for completed (the bottom of the card). Once a task is marked as completed, it will be moved from the top to bottom section and vice versa (a task can be re-opened as not completed).</br></br>
A card can also be shared among the users in the system, once shared, the other users can edit the shared card (title, background color, …) as well as the tasks included, no notification is sent to the owner once the card/ tasks are edited since we want to simply things right now.

- Tasks Management built with Laravel PHP Framework version 5.5.

## Getting Started

### Server Requirements

- PHP >= 7.0.0
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

### Local Server Setup with Homestead
This setup based on Laravel Documentation: https://laravel.com/docs/5.5/homestead#connecting-to-databases

### Local Development Server
On your application folder, you may use the 'serve' Artisan command. This command will start a development server at http://localhost:8000:
- php artisan serve

### Database Migrations
- php artisan migrate
- php artisan migrate --path=/database/migrations/alc
- php artisan migrate --path=/database/migrations/taskmng

## The following features are completed:
- Create/Update/Delete/Put Back To-do list.
- Add collaborator (Share todo-list).
- Delete To-do list Job (app/Console/Commands/deleteTodoList.php), command line to run this job manually: php artisan todolist:emptytrash

## Features which have not been done yet:
- Customize to-do list card color (in process).
- Search to-do list (in process).
- Admin page, so by now sadly we can NOT create, search or update user.

