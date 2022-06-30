# invitation_test

## endpoints

### send an invitation

    POST http://localhost/api/invitations/send

    curl -d '{"user_id":1,"email":"user@sample.com"}' -H 'Content-Type: application/json' -X POST http://localhost/api/invitations/send

### cancel an invitation

    PUT http://localhost/api/invitations/:id/cancel

    curl -d '{"id":1, "user_id":1}' -H 'Content-Type: application/json' -X PUT http://localhost/api/invitations/:id/cancel

### accept an invitation

    PUT http://localhost/api/invitations/:id/accept

    curl -d '{"id":1, "invitation_code":"62b7ed7aa6224"}' -H 'Content-Type: application/json' -X PUT http://localhost/api/invitations/:id/accept

### decline an invitation

    PUT http://localhost/api/invitations/:id/decline

    curl -d '{"id":1, "invitation_code":"62b7ed7aa6224"}' -H 'Content-Type: application/json' -X PUT http://localhost/api/invitations/:id/decline

## how to use

    docker exec invitation_test-app-1 php artisan migrate

## run test

    docker run --rm -v $(pwd):/app -w /app invitation-test_php php artisan test
