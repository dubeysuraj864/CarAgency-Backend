-- Create the 'cars' table
CREATE TABLE cars (
    vehicleId INT AUTO_INCREMENT PRIMARY KEY,
    vehicleModel VARCHAR(255) NOT NULL,
    vehicleNumber VARCHAR(20) NOT NULL,
    vehicleSeats INT NOT NULL,
    vehicleRent DECIMAL(8, 2) NOT NULL
);

-- Insert 20 car records
INSERT INTO cars (vehicleModel, vehicleNumber, vehicleSeats, vehicleRent) VALUES
    ('Toyota Camry', 'XYZ-123', 5, 50.00),
    ('Honda Civic', 'ABC-789', 5, 45.00),
    ('Ford Mustang', 'LMN-456', 4, 70.00),
    ('Chevrolet Tahoe', 'PQR-321', 7, 80.00),
    ('Nissan Altima', 'JKL-987', 5, 55.00),
    ('BMW X5', 'DEF-654', 5, 90.00),
    ('Audi A4', 'MNO-789', 5, 75.00),
    ('Tesla Model 3', 'GHI-567', 5, 95.00),
    ('Lexus RX', 'STU-234', 5, 85.00),
    ('Mercedes-Benz C-Class', 'VWX-901', 5, 80.00),
    ('Subaru Outback', 'QRS-432', 5, 60.00),
    ('Jeep Wrangler', 'NOP-765', 4, 70.00),
    ('Mazda CX-5', 'RST-123', 5, 65.00),
    ('Hyundai Sonata', 'UVW-345', 5, 50.00),
    ('Kia Sportage', 'CDE-678', 5, 55.00),
    ('Volkswagen Golf', 'HIJ-890', 5, 45.00),
    ('Volvo XC90', 'JKL-901', 7, 85.00),
    ('Jeep Grand Cherokee', 'XYZ-234', 5, 75.00),
    ('Ford Explorer', 'ABC-567', 7, 80.00),
    ('Chevrolet Cruze', 'MNO-432', 5, 50.00);
