import React from "react";
import { NavLink } from "react-router-dom";

interface ButtonProps {
  as?: "link" | "button";
  className?: string;
  type?: "fill" | "outline";
  color?: "primary" | "white";
  children: React.ReactNode;
}

function Button({
  as = "link",
  children,
  className = "",
  type = "fill",
  color = "primary",
}: ButtonProps) {
  const typeClass = {
    fill: {
      primary: "bg-cyan-900 text-white hover:bg-cyan-950",
      white:
        "bg-white text-cyan-900 outline outline-2 outline-transparent outline-offset-[-2px] hover:outline-cyan-800 duration-300 transition-all ease-in",
    },
    outline: {
      primary:
        "border border-cyan-900 text-cyan-900 outline outline-transparent outline-2 outline-offset-[-2px] hover:outline-2 hover:outline-cyan-900 transition-all duration-300 ease-in",
      white:
        "border border-neutral-50 text-neutral-50 outline outline-transparent outline-2 outline-offset-[-2px] hover:outline-2 hover:outline-neutral-50 transition-all duration-300 ease-in",
    },
  };

  const combinedClassName = `cursor-pointer ${typeClass[type][color]} ${className} decoration-0 transition-all duration-300`;

  if (as === "link") {
    return (
      <NavLink to="/" className={combinedClassName}>
        {children}
      </NavLink>
    );
  }

  if (as === "button") {
    return <button className={combinedClassName}>{children}</button>;
  }

  return null;
}

export default Button;
