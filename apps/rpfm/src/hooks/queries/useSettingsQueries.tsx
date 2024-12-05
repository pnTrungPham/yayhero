import { useMutation, useQuery, useQueryClient } from "react-query";
import { getSettings, updateSettings } from "../../api/wpSourceEndpoint";
import { useWPSourceStore } from "../../store/wpSourceStore";

interface IHookProps {
  fetch?: boolean;
}

function useSettingsQueries(props?: IHookProps) {
  const queryClient = useQueryClient();

  const queryResult = useQuery({
    queryKey: ["settings"],
    queryFn: async () => {
      const response = await getSettings();
      useWPSourceStore.setState((state) => {
        state.isLoading = true;
      });
      if (response.data && response.data.isError) {
        throw new Error(response.data.message ?? "Unknown error");
      }
      useWPSourceStore.setState((state) => {
        state.settings = response.data;
        state.isLoading = false;
      });
      return response.data;
    },
    retry: false,
    refetchOnWindowFocus: false,
    enabled: props?.fetch ?? true,
    keepPreviousData: true,
  });

  const saveSettingsMutation = useMutation({
    mutationFn: updateSettings,
    onMutate: () => {
      useWPSourceStore.setState((state) => {
        state.isLoading = true;
      });
    },
    onSettled: () => {
      useWPSourceStore.setState((state) => {
        state.isLoading = false;
      });
    },
    onSuccess: () => {
      useWPSourceStore.setState((state) => {
        state.isLoading = false;
      });
      return queryClient.invalidateQueries({ queryKey: ["settings"] });
    },
  });

  return {
    ...queryResult,
    saveSettingsMutation,
  };
}

export default useSettingsQueries;
