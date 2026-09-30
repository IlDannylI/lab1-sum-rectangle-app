import sys
import math


def calculate_area(length, width):
    return length * width


def calculate_perimeter(length, width):
    return 2 * (length + width)


def main():
    if len(sys.argv) != 3:
        print("Error: Length and width are required.")
        sys.exit(1)

    try:
        length = float(sys.argv[1])
        width = float(sys.argv[2])
    except ValueError:
        print("Error: Please enter valid numbers.")
        sys.exit(1)

    if not (math.isfinite(length) and math.isfinite(width)):
        print("Error: Numbers must be finite.")
        sys.exit(1)

    if length <= 0 or width <= 0:
        print("Error: Length and width must be greater than zero.")
        sys.exit(1)

    area = calculate_area(length, width)
    perimeter = calculate_perimeter(length, width)

    print(f"Area = {length:g} x {width:g} = {area:g}")
    print(f"Perimeter = 2 x ({length:g} + {width:g}) = {perimeter:g}")


if __name__ == "__main__":
    main()
