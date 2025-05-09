# Car Rental API Project Documentation

## Project Overview
A Laravel-based car rental system for the Web-Based Systems (IS-314) course at KFU. Consists of:
- RESTful API (CarRentalAPI)
- Web client (CarRentalClient)
- Worth 20% of final grade

## Core Requirements
- Database: `car_rental_web_service` (MySQL)
- API built with Laravel REST architecture
- Authentication via Laravel Sanctum
- 20-30 preloaded car records
- Remote server deployment

## Web Service Tasks

### 1. Database Setup (0.5 marks)
- Create cars table with required fields
- Preload 25 car records

### 2. Authentication (1 mark)
- Implement users table
- Configure Laravel Sanctum
- Seed sample users

### 3. API Endpoints (2 marks)
- GET `/api/cars`
- GET `/api/cars/{id}`
- POST `/api/login`

### 4. Data Creation (1 mark)
- POST `/api/cars`
- Input validation
- Protected routes

### 5. Deployment (5 marks)
- Deploy to free hosting service (I will deploy it later in azure I have server)
- Configure remote database
- Ensure endpoint functionality

## Web Application Tasks

### 1. Authentication (1 mark)
- Login interface
- Token management

### 2. Data Retrieval (2 marks)
- Fetch and display cars
- Authenticated requests

### 3. Data Creation (2 marks)
- Car creation form
- API integration

### 4. Dashboard (2 marks)
- Dynamic data display
- Styled interface

## Submission Requirements
- Deadline: Week 15
- Required files: 
    - CarRentalAPI (zip)
    - CarRentalClient (zip)
    - Database dump (.sql)
    - Peer review forms

## Grading
Total: 20 marks
- Late submission: -2 marks/day

