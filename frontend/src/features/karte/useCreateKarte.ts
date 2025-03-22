import { useMutation } from "@tanstack/react-query";
import { useNavigate } from "react-router-dom";
import { useSetSession as SetSession } from "../../hooks/useSession";
import { postDiagnosis as postDiagnosisApi } from "../../services/apiDiagnosis";

export function useCreateKarte() {
  const navigate = useNavigate();

  const { mutate: createKarte, isPending: isCreating } = useMutation({
    mutationFn: postDiagnosisApi,
    onSuccess: (data) => {
      SetSession({
        key: "karte",
        value: `${JSON.stringify(data.diagnosis)}`,
      });
      navigate("/result");
    },
    onError: (err) => console.error(err.message),
  });

  return { createKarte, isCreating };
}
