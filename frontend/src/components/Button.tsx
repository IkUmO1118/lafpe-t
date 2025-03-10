import React from "react";

interface ButtonProps {
  as?: "link" | "button";
  className?: string;
  type?: "primary" | "outline";
  children: React.ReactNode;
}

function Button({
  as = "link",
  children,
  className = "",
  type = "primary",
}: ButtonProps) {
  const typeClass =
    type === "primary"
      ? "bg-cyan-900 text-neutral-50 hover:bg-cyan-950"
      : "border border-cyan-900 text-cyan-900";

  const combinedClassName = `cursor-pointer ${typeClass} ${className} decoration-0 transition-all duration-300`;

  if (as === "link") {
    return <a className={combinedClassName}>{children}</a>;
  }

  if (as === "button") {
    return <button className={combinedClassName}>{children}</button>;
  }

  return null;
}

export default Button;
