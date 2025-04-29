# MapMaster API Documentation

This document outlines the available API endpoints for the MapMaster application. These APIs allow for programmatic interaction with the MapMaster system.

## Authentication

API authentication is handled through Laravel Sanctum. To authenticate API requests:

1. Obtain an API token by sending a POST request to `/api/login`
2. Include the token in the Authorization header as `Bearer {token}`

Example:

```
Authorization: Bearer 1|abcdef123456...
```

## API Endpoints

### Authentication

#### POST /api/login

Authenticates a user and returns an API token.

**Request Body:**

```json
{
  "email": "user@example.com",
  "password": "password"
}
```

**Response:**

```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "role": "customer",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  },
  "token": "1|abcdef123456..."
}
```

#### POST /api/logout

Invalidates the current API token.

**Headers:**

- Authorization: Bearer {token}

**Response:**

```json
{
  "message": "Successfully logged out"
}
```

### Designs

#### GET /api/designs

Returns a list of available designs.

**Headers:**

- Authorization: Bearer {token}

**Query Parameters:**

- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 10)
- `category_id`: Filter by category ID
- `marla`: Filter by marla size

**Response:**

```json
{
  "data": [
    {
      "id": 1,
      "name": "Modern Villa",
      "description": "A modern villa design with 5 bedrooms",
      "thumbnail": "thumbnails/design1.jpg",
      "category_id": 1,
      "marla": 10,
      "no_of_rooms": 5,
      "no_of_floors": 2,
      "price": 5000,
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
    // More designs...
  ],
  "links": {
    "first": "http://localhost:8000/api/designs?page=1",
    "last": "http://localhost:8000/api/designs?page=5",
    "prev": null,
    "next": "http://localhost:8000/api/designs?page=2"
  },
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "from": 1,
    "to": 10,
    "total": 50,
    "per_page": 10
  }
}
```

#### GET /api/designs/{id}

Returns details for a specific design.

**Headers:**

- Authorization: Bearer {token}

**Response:**

```json
{
  "data": {
    "id": 1,
    "name": "Modern Villa",
    "description": "A modern villa design with 5 bedrooms",
    "thumbnail": "thumbnails/design1.jpg",
    "category_id": 1,
    "marla": 10,
    "no_of_rooms": 5,
    "no_of_floors": 2,
    "price": 5000,
    "category": {
      "id": 1,
      "name": "Modern"
    },
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  }
}
```

### Generate Design

#### POST /api/generate-design

Generates a new house design based on specified parameters.

**Headers:**

- Authorization: Bearer {token}

**Request Body:**

```json
{
  "house_type": "modern",
  "num_marla": 10,
  "num_floors": 2,
  "num_bedrooms": 4,
  "additional_preferences": ["open kitchen", "garage"]
}
```

**Response:**

```json
{
  "success": true,
  "image": "http://localhost:8000/storage/thumbnails/generated_123.jpg",
  "from_database": false,
  "design_id": null
}
```

### Categories

#### GET /api/categories

Returns a list of available design categories.

**Headers:**

- Authorization: Bearer {token}

**Response:**

```json
{
  "data": [
    {
      "id": 1,
      "name": "Modern",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    },
    {
      "id": 2,
      "name": "Traditional",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
    // More categories...
  ]
}
```

### Wishlist

#### GET /api/wishlist

Returns the user's wishlist items.

**Headers:**

- Authorization: Bearer {token}

**Response:**

```json
{
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "design_id": 3,
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z",
      "design": {
        "id": 3,
        "name": "Suburban House",
        "thumbnail": "thumbnails/design3.jpg",
        "marla": 7,
        "no_of_rooms": 3,
        "no_of_floors": 1,
        "price": 3500
      }
    }
    // More wishlist items...
  ]
}
```

#### POST /api/wishlist

Adds a design to the user's wishlist.

**Headers:**

- Authorization: Bearer {token}

**Request Body:**

```json
{
  "design_id": 5
}
```

**Response:**

```json
{
  "success": true,
  "message": "Design added to wishlist!"
}
```

#### DELETE /api/wishlist/{id}

Removes a design from the user's wishlist.

**Headers:**

- Authorization: Bearer {token}

**Response:**

```json
{
  "success": true,
  "message": "Design removed from wishlist"
}
```

### Design Requests

#### POST /api/designs/request

Creates a custom design request.

**Headers:**

- Authorization: Bearer {token}

**Request Body:**

```json
{
  "marla": 15,
  "no_of_rooms": 6,
  "no_of_floors": 3,
  "description": "Looking for a modern design with a large kitchen and swimming pool",
  "category_id": 1
}
```

**Response:**

```json
{
  "success": true,
  "message": "Design request submitted successfully",
  "request_id": 12
}
```

## Error Responses

All API endpoints return appropriate HTTP status codes:

- 200: Success
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 422: Validation Error
- 500: Server Error

Error response format:

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field_name": ["Validation error message"]
  }
}
```

## Rate Limiting

API requests are rate-limited to prevent abuse. Headers in the response indicate your rate limit status:

- `X-RateLimit-Limit`: Maximum number of requests allowed per minute
- `X-RateLimit-Remaining`: Number of requests remaining in the current minute
- `X-RateLimit-Reset`: Time in seconds until the rate limit resets

If you exceed the rate limit, a 429 Too Many Requests response will be returned.

## Changelog

### Version 1.0 (Current)

- Initial API release
- Basic CRUD operations for designs, categories, and wishlist
- Authentication using Laravel Sanctum
