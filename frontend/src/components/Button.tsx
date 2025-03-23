import React from "react";
import { Slot } from "@radix-ui/react-slot";
import { cva, VariantProps } from "class-variance-authority";
import { cn } from "../lib/utils";

const buttonVariants = cva(
  "cursor-pointer decoration-0 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed",
  {
    variants: {
      variant: {
        fillPrimary: "bg-cyan-900 text-white hover:bg-cyan-950",
        fillWhite:
          "bg-white text-cyan-900 outline outline-2 outline-transparent outline-offset-[-2px] hover:outline-cyan-800 duration-300 transition-all ease-in",
        outlinePrimary:
          "border border-cyan-900 text-cyan-900 outline outline-transparent outline-2 outline-offset-[-2px] hover:outline-2 hover:outline-cyan-900 transition-all duration-300 ease-in",
        outlineWhite:
          "border border-neutral-50 text-neutral-50 outline outline-transparent outline-2 outline-offset-[-2px] hover:outline-2 hover:outline-neutral-50 transition-all duration-300 ease-in",
      },
      size: {
        sm: "rounded-sm px-5 py-2 text-sm font-medium", //header
        base: "rounded-sm px-6 py-4 text-base font-bold", //Hero section
        wide: "min-h-12 w-full rounded-sm py-3 font-bold", //feedback
        lg: "rounded-sm px-10 py-4 text-base font-medium", // cta
        xl: "rounded-sm px-6 py-3 text-base font-medium", // download pdf
        xl2: "rounded-md min-w-26 px-6 py-2 text-sm font-medium", // result/update
      },
    },
    defaultVariants: {
      variant: "fillPrimary",
      size: "base",
    },
  },
);

export interface ButtonProps
  extends React.ButtonHTMLAttributes<HTMLButtonElement>,
    VariantProps<typeof buttonVariants> {
  asChild?: boolean;
}

const Button = React.forwardRef<HTMLButtonElement, ButtonProps>(
  ({ className, variant, size, asChild = false, ...props }, ref) => {
    const Comp = asChild ? Slot : "button";
    return (
      <Comp
        className={cn(buttonVariants({ variant, size, className }))}
        ref={ref}
        {...props}
      />
    );
  },
);
Button.displayName = "Button";

export { Button };
